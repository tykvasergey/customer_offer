<?php

namespace BroSolutions\CustomOffer\Model;

class OfferRepository implements \BroSolutions\CustomOffer\Api\OfferRepositoryInterface
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var \BroSolutions\CustomOffer\Model\ResourceModel\Offer
     */
    private $offerResource;

    /**
     * @var \BroSolutions\CustomOffer\Model\OfferFactory
     */
    private $offerFactory;

    /**
     * @var \BroSolutions\CustomOffer\Model\ResourceModel\Offer\OfferCollectionFactory
     */
    private $offerCollectionFactory;


    private $productRepository;

    /**
     * @var \BroSolutions\CustomOffer\Api\Data\OfferSearchResultInterfaceFactory
     */
    private $offerSearchResultFactory;


    /**
     * OfferRepository constructor.
     *
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \BroSolutions\CustomOffer\Model\ResourceModel\Offer $offerResource
     * @param \BroSolutions\CustomOffer\Model\OfferFactory $offerFactory
     * @param \BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory $offerCollectionFactory
     * @param \BroSolutions\CustomOffer\Api\Data\OfferSearchResultInterfaceFactory $offerSearchResultFactory
     */
    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \BroSolutions\CustomOffer\Model\ResourceModel\Offer $offerResource,
        \BroSolutions\CustomOffer\Model\OfferFactory $offerFactory,
        \BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory $offerCollectionFactory,
        \BroSolutions\CustomOffer\Api\Data\OfferSearchResultInterfaceFactory $offerSearchResultFactory
    ) {
        $this->offerResource = $offerResource;
        $this->offerFactory = $offerFactory;
        $this->offerCollectionFactory = $offerCollectionFactory;
        $this->offerSearchResultFactory = $offerSearchResultFactory;
        $this->productRepository = $productRepository;
    }


    public function get(int $id)
    {
        if (!array_key_exists($id, $this->registry)) {
            $offer = $this->offerFactory->create();
            $this->offerResource->load($offer, $id);
            if (!$offer->getId()) {
                throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested Offer does not exist'));
            }
            $this->registry[$id] = $offer;
        }

        return $this->registry[$id];
    }


    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \BroSolutions\CustomOffer\Model\ResourceModel\Offer\Collection $collection */
        $collection = $this->offerCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        /** @var \BroSolutions\CustomOffer\Api\Data\OfferSearchResultInterface $searchResult */
        $searchResult = $this->offerSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }


    public function save(\BroSolutions\CustomOffer\Api\Data\OfferInterface $offer)
    {
        try {
            /** @var Offer $offer */
            $this->offerResource->save($offer);
            $this->registry[$offer->getId()] = $this->get($offer->getId());
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\StateException(__('Unable to save Offer #%1', $offer->getId()));
        }
        return $this->registry[$offer->getId()];
    }


    public function delete(\BroSolutions\CustomOffer\Api\Data\OfferInterface $offer)
    {
        try {
            /** @var Offer $offer */
            $this->offerResource->delete($offer);
            unset($this->registry[$offer->getId()]);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(__('Unable to remove offer #%1', $offer->getId()));
        }

        return true;
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById(int $id)
    {
        return $this->delete($this->get($id));
    }
}