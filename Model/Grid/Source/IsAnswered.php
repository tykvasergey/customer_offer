<?php

namespace BroSolutions\CustomOffer\Model\Grid\Source;

/**
 * Class IsActive
 */
class IsAnswered implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $offerPage;

    /**
     * Constructor
     *
     * @param \BroSolutions\CustomOffer\Model\Offer $offerPage
     */
    public function __construct(\BroSolutions\CustomOffer\Model\Offer $offerPage)
    {
        $this->offerPage = $offerPage;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->offerPage->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}