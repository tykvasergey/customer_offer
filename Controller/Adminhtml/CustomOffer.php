<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml;

abstract class CustomOffer extends \Magento\Backend\App\Action
{
    /**
     * @var string
     */
    const ACTION_RESOURCE = 'BroSolutions_CustomOffer::offer';
    /**
     * Offer repository
     *
     * @var \BroSolutions\CustomOffer\Api\OfferRepositoryInterface
     */
    protected $offerRepository;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * Result Forward Factory
     *
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * ContactUsSaver constructor.
     *
     * @param \Magento\Framework\Registry $registry
     * @param \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $registry;
        $this->offerRepository = $offerRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
    }
}