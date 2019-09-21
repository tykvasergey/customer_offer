<?php

namespace BroSolutions\CustomOffer\Controller\Index;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    protected $offerFactory;

    protected $offerRepository;

    protected $dataObjectHelper;

    /**
     * Post constructor.
     *
     * @param \BroSolutions\CustomOffer\Model\OfferRepository $offerRepository
     * @param \BroSolutions\CustomOffer\Model\OfferFactory $offerFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \BroSolutions\CustomOffer\Model\OfferRepository $offerRepository,
        \BroSolutions\CustomOffer\Model\OfferFactory $offerFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->offerRepository = $offerRepository;
        $this->offerFactory = $offerFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);


        $post = (array) $this->getRequest()->getParams();
        $productId = $post['product_id'];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
        if (!empty($post)) {
            $email   = $post['email'];
            $another_store_link    = $post['another_store_link'];
            $your_price       = $post['your_price'];
            $qty = $post['qty'];
            $productId = $post['product_id'];

            if ($post['your_price'] >= $product['price']){
                return $this->messageManager->addWarningMessage("why?");
            }
            $model = $this->offerFactory->create();
            $this->dataObjectHelper->populateWithArray($model, $post, \BroSolutions\CustomOffer\Api\Data\OfferInterface::class);
            $this->offerRepository->save($model);

            $this->messageManager->addSuccessMessage('Done !');

            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

    }
}

