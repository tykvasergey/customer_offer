<?php

namespace BroSolutions\CustomOffer\Block\Catalog\Product\View;

class  CustomButton extends \Magento\Framework\View\Element\Template
{

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        $productId = $this->getRequest()->getParam('id');
        return $this->getUrl('customoffer/index/post',
            ['product_id' => $productId]);

    }
}