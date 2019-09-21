<?php

namespace BroSolutions\CustomOffer\Block\Adminhtml\Offer\Edit\Buttons;

class Delete extends Generic implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getOfferId()) {
            $data = [
                'label' => __('Delete Offer'),
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
        return $this->getUrl('*/*/delete', ['offer_id' => $this->getOfferId()]);
    }
}