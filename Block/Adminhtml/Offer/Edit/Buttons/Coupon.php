<?php

namespace BroSolutions\CustomOffer\Block\Adminhtml\Offer\Edit\Buttons;

class Coupon extends Generic implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getOfferId()) {
            $data = [
                'label' => __('Generate Coupon and Back'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/coupon', ['offer_id' => $this->getOfferId()]);
    }

}
