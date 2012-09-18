<?php

class Centerax_Pdfcatalog_IndexController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
       	->_setActiveMenu('catalog')
        ->_addBreadcrumb($this->__('Catalog'), $this->__('Catalog'))
        ->_addBreadcrumb($this->__('PDF Catalog'), $this->__('PDF Catalog'))
        ->_addBreadcrumb($this->__('List'), $this->__('List'));
        return $this;
    }

	public function listAction()
	{
			$this->_initAction()
            ->_addContent($this->getLayout()->createBlock('pdfcatalog/index_list'))
            ->renderLayout();
	}

    public function listGridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('pdfcatalog/index_grid')->toHtml()
        );
    }

    public function createAction()
    {
        $this->loadLayout(array(
                'default',
                'pdfcatalog_index_index'
            ));
		$this->_setActiveMenu('catalog');

        $this->renderLayout();
    }

	protected function _getConfValue($id)
	{
		return Mage::getStoreConfig('catalog/ecatalog/'.$id);
	}

	protected function _setPdfDocumentProps()
	{
		$props = array();
		$props['Title'] = $this->_getConfValue('title');
		$props['Creator'] = 'Centerax_Pdfcatalog Magento Extension';
		$props['Author'] = $this->_getConfValue('author');
		$props['Keywords'] = $this->_getConfValue('keywords');
		$props['Subject'] = $this->_getConfValue('subject');

		return $props;
	}

	/**
	* Return length of generated string in points
	*
	* @param string $string
	* @param Zend_Pdf_Resource_Font $font
	* @param int $font_size
	* @return double
	*/
	public function getTextWidth($text, Zend_Pdf_Resource_Font $font, $font_size)
	{
		 $drawing_text = iconv('UTF-8', 'UTF-16BE', $text);
		 $characters    = array();
		 for ($i = 0; $i < strlen($drawing_text); $i++) {
		  $characters[] = (ord($drawing_text[$i++]) << 8) | ord ($drawing_text[$i]);
		 }
		 $glyphs        = $font->glyphNumbersForCharacters($characters);
		 $widths        = $font->widthsForGlyphs($glyphs);
		 $text_width   = (array_sum($widths) / $font->getUnitsPerEm()) * $font_size;
		 return $text_width;
	}

    public function saveAction()
    {
    	$post = $this->getRequest()->getPost();

		$productsSkus = explode(', ', $post['skus']);

		$pdf = new Zend_Pdf();
		$pdf->properties = $this->_setPdfDocumentProps();

		//Add one page per product
		foreach($productsSkus as $sku){

			$productId = Mage::getModel('catalog/product')->getIdBySku($sku);
			$product = Mage::getModel('catalog/product')->load($productId);

			$page = new Zend_Pdf_Page($post['page_size']);
			$pdf->pages[] = $page;

			$font = Zend_Pdf_Font::fontWithName($post['font_type']);
			$page->setFont($font, $post['font_size']);

			$pageSize = $page->getHeight();

			$availW = $page->getWidth() - 100;

			$xpos = 50;
			$ypos = $pageSize;

			asort($post['attribs']);

			foreach($post['attribs'] as $at){
				$ypos -= $post['font_size']*0.75 + 5;
				if($at != 'image'){

					$length = $this->getTextWidth($product->{$at}, $font, $post['font_size']);
					$ln = (strlen($product->{$at}) > 0) ? strlen($product->{$at}) : 1;
					$avg = intval(($length / $ln) + 0.5);

					$ww = floor($availW / ($avg == 0 ? 1 : $avg));

					if($at == 'url_key'){
						$text = $this->__('For more info, visit: %s', Mage::getUrl('/') . $product->getUrlPath());
					}else{
						$text = wordwrap($product->{$at}, $ww, "\n", true);
					}

					if($at == 'price'){
						$text = $this->__('Price: %s', Mage::helper('core')->formatPrice($text, false));
					}

					$token = strtok($text, "\n");
					while ($token != false) {
		                if ($ypos < 60) {
		                	    $page = new Zend_Pdf_Page($post['page_size']);
		                        $pdf->pages[] = $page;
								$font = Zend_Pdf_Font::fontWithName($post['font_type']);
								$page->setFont($font, $post['font_size']);
								$xpos = 50;
		                        $ypos = $pageSize;
		                } else {
							$page->drawText($token, $xpos, $ypos, 'UTF-8');
							$ypos -= $post['font_size']*0.75 + 5;
							$token = strtok("\n");
		                }
					}

				}else{
					try{

						$mainImage = $product->getMediaGalleryImages()->getFirstItem();
						if($mainImage->getPath()){
								$imgHeight = isset($post['image_height']) ? $post['image_height'] : 100;
								$imgWidth = isset($post['image_width']) ? $post['image_width'] : 100;

								$ypos -= ($imgHeight + $post['font_size']) + 5;
								// Resize image and stemporarily save generated image
								$fullImage = imagecreatefromjpeg($mainImage->getPath());
								$fullSize = getimagesize($mainImage->getPath());
								$tnImage = imagecreatetruecolor($imgWidth, $imgHeight);
								imagecopyresampled($tnImage,$fullImage,0,0,0,0,$imgWidth,$imgHeight,$fullSize[0],$fullSize[1]);

								try{
									$imgtemp = Mage::getBaseDir('var') .'/cache/'.$mainImage->getValueId().'.jpg';
									imagejpeg($tnImage, $imgtemp, 100);
								}catch(Exception $e){
									Mage::log($e->getMessage());
								}

								$image = Zend_Pdf_Image::imageWithPath($imgtemp);

								$height = $imgHeight * 0.75;
								$width = $imgWidth * 0.75;
								$offset = ($page->getWidth() - $width) / 2;
								$x1 = $offset + 0; $y1 = $page->getHeight() - 10;
								$x2 = $offset + $width;
								$y2 = $y1 - $height;

								// Draw image
								$page->drawImage($image, $x1, $y2, $x2, $y1);

								//unlink($imgtemp);
						}

					}catch(Exception $e){
						$this->_getSession()->addError($this->__($e->getMessage()));
						Mage::logException($e);
					}
				}
			}

		}

		$bs = $this->_beforePdfSave();
		if(is_string($bs)){
			$pdf->save($bs);
		}else if($bs == -1){
			$this->_getSession()->addError($this->__('File already exists'));

			$this->_redirect('*/*/list', array(
                	'_current'=>true
            	));
            return;
		}

		$this->_getEcatalog()->saveNew($post);

		$this->_redirect('*/*/list', array(
                '_current'=>true
            ));
    }

	public function _beforePdfSave()
	{
		$filename = $this->getRequest()->getParam('pdfname');
		$rootDir = $this->_getEcatsDir();

		if(!is_dir($rootDir)){
			try{
				mkdir($rootDir);
			}catch(Exception $e){
				Mage::logException($e);
				return false;
			}
		}

		$f = $rootDir . $this->fname($filename) . '.pdf';

		if(file_exists($f)){
			return (int)-1;
		}else{
			return (string)$f;
		}

	}

	public function fname($name)
	{
		return Mage::helper('pdfcatalog')->sanitizeFilename($name);
	}


	protected function _getEcatalog()
	{
		return Mage::getModel('pdfcatalog/ecatalog_ecatalog');
	}

	public function downloadAction()
	{
		$id = $this->getRequest()->getParam('id');
		if(!$id){
			$this->_getSession()->addError($this->__('ID not provided'));
			$this->_redirect('*/*/list');
			return;
		}

		$obj = $this->_getEcatalog()->load($id);

		if($obj->getId()){
			try{
				$filename = $this->_getEcatsDir() . $obj->getFilename() . '.pdf';
				$handle = fopen($filename, "r");
				$contents = fread($handle, filesize($filename));
				fclose($handle);
				$this->_prepareDownloadResponse($obj->getFilename(), $contents, 'application/x-pdf');

			}catch(Exception $e){
				$this->_getSession()->addError($this->__('Could not open file'));
				$this->_redirect('*/*/list');
				return;
			}
		}else{
			$this->_getSession()->addError($this->__('Catalog does not exist'));
			$this->_redirect('*/*/list');
			return;
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		if(!$id){
			$this->_getSession()->addError($this->__('ID not provided'));
			$this->_redirect('*/*/list');
			return;
		}

		$obj = $this->_getEcatalog()->load($id);

		if($obj->getId() && $this->_getEcatalog()->setId($id)->delete()){
			try{
				unlink($this->_getEcatsDir() . $obj->getFilename() . '.pdf');
			}catch(Exception $e){
				$this->_getSession()->addError($this->__('Could not delete PDF on file system'));
				$this->_redirect('*/*/list');
				return;
			}
		}

		$this->_getSession()->addSuccess($this->__('Record successfuly deleted'));
		$this->_redirect('*/*/list');
		return;
	}

	protected function _getEcatsDir()
	{
		return Mage::getBaseDir('var') . '/ecatalogs/';
	}

}