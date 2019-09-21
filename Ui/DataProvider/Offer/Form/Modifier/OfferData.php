<?php

namespace BroSolutions\CustomOffer\Ui\DataProvider\Offer\Form\Modifier;

class OfferData implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    /**
     * @var \BroSolutions\CustomOffer\Model\ResourceModel\Offer\Collection
     */
    protected $collection;
    /**
     * @param \BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory $offerCollectionFactory
     */
    public function __construct(
        \BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory $offerCollectionFactory
    ) {
        $this->collection = $offerCollectionFactory->create();
    }
    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function modifyData(array $data)
    {
        $items = $this->collection->getItems();
        /** @var $offer \BroSolutions\CustomOffer\Model\Offer */
        foreach ($items as $offer) {
            $_data = $offer->getData();
            $offer->setData($_data);
            $data[$offer->getId()] = $_data;
        }
        return $data;
    }
}