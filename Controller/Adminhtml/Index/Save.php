<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml\Index;
/**
 * Class Save
 * @package Polushkin\ContactUsSaver\Controller\Adminhtml\Index
 */
class Save extends  \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var \BroSolutions\CustomOffer\Api\Data\OfferInterfaceFactory
     */
    protected $offerInterfaceFactory;
    /**
     * @var \BroSolutions\CustomOffer\Api\OfferRepositoryInterface
     */
    protected $offerRepository;


    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \BroSolutions\CustomOffer\Api\Data\OfferInterfaceFactory $offerInterfaceFactory
     * @param \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \BroSolutions\CustomOffer\Api\Data\OfferInterfaceFactory $offerInterfaceFactory,
        \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->offerInterfaceFactory = $offerInterfaceFactory;
        $this->offerRepository = $offerRepository;
        parent::__construct($context);
    }


    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            if (empty($data['offer_id'])) {
                $data['offer_id'] = null;
            }
            if (!$data['answer_to_offer'] == '') {
                    $data['offer_status'] = '1';
            }
            /** @var \BroSolutions\CustomOffer\Model\Offer $model */
            $model = $this->offerInterfaceFactory->create();
            $id = $this->getRequest()->getParam('offer_id');
            if ($id) {
                try {
                    $model = $this->offerRepository->get($id);
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This Offer no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {

                $this->offerRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Contact.'));
                $this->dataPersistor->clear('offer');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['offer_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Offer.'));
            }
            $this->dataPersistor->set('brosolutions_customoffer_offer', $data);
            return $resultRedirect->setPath('*/*/edit', ['offer_id' => $this->getRequest()->getParam('offer_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}