<?php

namespace BroSolutions\CustomOffer\Api\Data;

interface OfferSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \BroSolutions\CustomOffer\Api\Data\OfferInterface[]
     */
    public function getItems();

    /**
     * @param \BroSolutions\CustomOffer\Api\Data\OfferInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}