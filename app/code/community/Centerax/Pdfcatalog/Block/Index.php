<?php

class Centerax_Pdfcatalog_Block_Index extends Mage_Adminhtml_Block_Widget
{

    protected function _prepareLayout()
    {
        $this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('pdfcatalog')->__('Back'),
                        'onclick' => "window.location.href = '" . $this->getUrl('*/*/list') . "'",
                            'class' => 'back'
                    )
                )
        );


        $this->setChild('reset_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('pdfcatalog')->__('Reset'),
                        'onclick' => 'window.location.href = window.location.href'
                    )
                )
        );

        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('pdfcatalog')->__('Save'),
                        'onclick' => 'pdfForm.submit();',
                            'class' => 'save'
                    )
                )
        );

        return parent::_prepareLayout();
    }

    public function getBackButtonHtml()
    {
        return $this->getChildHtml('back_button');
    }

    public function getResetButtonHtml()
    {
        return $this->getChildHtml('reset_button');
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }

    /**
     * Return header text for form
     *
     * @return string
     */
    public function getHeaderText()
    {
        return  Mage::helper('pdfcatalog')->__('New E-Catalog');
    }

    /**
     * Return form block HTML
     *
     * @return string
     */
    public function getForm()
    {
        return $this->getLayout()->createBlock('pdfcatalog/form')
            ->renderPrepare()
            ->toHtml();
    }

    /**
     * Return action url for form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }

}

