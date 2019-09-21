<?php

namespace BroSolutions\CustomOffer\Block\Adminhtml\Offer\Edit\Buttons;

class Generic
{
    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;
    /**
     * @var \BroSolutions\CustomOffer\Api\OfferRepositoryInterface
     */
    protected $offerRepository;
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository
    ) {
        $this->context = $context;
        $this->offerRepository = $offerRepository;
    }
    /**
     * Return offer ID
     *
     * @return int|null
     */
    public function getOfferId()
    {
        return $this->context->getRequest()->getParam('offer_id');
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}