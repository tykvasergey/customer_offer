<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace BroSolutions\CustomOffer\Ui\DataProvider;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;


/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    public $offerRepository;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder1,
        array $meta = [],
        array $data = []
    ) {
        $this->request = $request;
        $this->filterBuilder = $filterBuilder;
        $this->name = $name;
        $this->primaryFieldName = $primaryFieldName;
        $this->requestFieldName = $requestFieldName;
        $this->reporting = $reporting;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->meta = $meta;
        $this->data = $data;
        $this->offerRepository = $offerRepository;
        $this->searchCriteriaBuilder1 = $searchCriteriaBuilder1;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
         $searchCriteriaBuilder,
        $request,
        $filterBuilder,
        $meta ,
             $data
        );
    }
    /**
     * @param SearchResultInterface $searchResult
     * @return array
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        $arrItems = [];

        $arrItems['items'] = [];
        foreach ($searchResult->getItems() as $item) {
            $itemData = [];
            foreach ($item->getCustomAttributes() as $attribute) {
                $itemData[$attribute->getAttributeCode()] = $attribute->getValue();
            }
            $arrItems['items'][] = $itemData;
        }

        $arrItems['totalRecords'] = $searchResult->getTotalCount();
$_filter = $this->searchCriteriaBuilder1->addFilter("offer_id", "%%", "like")->create();
       $items = $this->offerRepository->getList($_filter);
       $items = $items->getItems();
       $result = [];
       foreach ($items as $item){
           $result[] = $item->getData();
       }
        return $arrItems;
//        return $result;
    }


    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->searchResultToOutput($this->getSearchResult());
    }


}
