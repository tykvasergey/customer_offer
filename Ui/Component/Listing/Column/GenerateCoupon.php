<?php

namespace BroSolutions\CustomOffer\Ui\Component\Listing\Column;


class GenerateCoupon extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $offerRepository;
    protected $searchCriteria;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \BroSolutions\CustomOffer\Model\OfferRepository $offerRepository
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \BroSolutions\CustomOffer\Model\OfferRepository $offerRepository,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->offerRepository = $offerRepository;
        $this->searchCriteria = $searchCriteria;
    }



    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                    $test = $item[$this->getData('product_price') - $this->getData('your_price')];
                if(empty($item[$this->getData('product_price')])) {
                    $item[$this->getData('product_price ')] =  ['product_price' => '0'];
                }
 $item[$this->getData('address_approved')] = 0;//Value which you want to display
            }
        }
        return $dataSource;
    }
}