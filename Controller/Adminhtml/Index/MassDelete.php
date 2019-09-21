<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use BroSolutions\CustomOffer\Api\OfferRepositoryInterface;
use BroSolutions\CustomOffer\Controller\Adminhtml\CustomOffer;
use BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory;

class MassDelete extends CustomOffer
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;
    /**
     * @var string
     */
    protected $successMessage;
    /**
     * @var string
     */
    protected $errorMessage;
    /**
     * MassDelete constructor.
     * @param Registry $registry
     * @param OfferRepositoryInterface $offerRepository
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param $successMessage
     * @param $errorMessage
     */
    public function __construct(
        Registry $registry,
        OfferRepositoryInterface $offerRepository,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        parent::__construct($registry, $offerRepository, $resultPageFactory, $resultForwardFactory, $context);
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->successMessage    = $successMessage;
        $this->errorMessage      = $errorMessage;
    }
    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $offer) {
                $this->offerRepository->delete($offer);
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __($this->errorMessage));
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('customoffer/index');

        return $redirectResult;
    }
}