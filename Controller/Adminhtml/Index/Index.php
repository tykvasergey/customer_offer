<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    public $offerRepository;
    public $searchCriteriaBuilder;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        parent::__construct($context);
        $this->offerRepository = $offerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    public function execute()
    {
//        $_filter = $this->searchCriteriaBuilder->addFilter("offer_id", "%%", "like")->create();
        //$this->offerRepository->getList($_filter);
        return $this->resultFactory->create( \Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
    }
}