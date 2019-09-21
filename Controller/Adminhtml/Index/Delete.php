<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends \BroSolutions\CustomOffer\Controller\Adminhtml\CustomOffer
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $offerId = $this->getRequest()->getParam('offer_id');
        if ($offerId) {
            try {
                $this->offerRepository->deleteById($offerId);
                $this->messageManager->addSuccessMessage(__('The offer has been deleted.'));
                $resultRedirect->setPath('customoffer/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The offer no longer exists.'));
                return $resultRedirect->setPath('customoffer/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('customoffer/index', ['offer_id' => $offerId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the offer'));
                return $resultRedirect->setPath('customoffer/index', ['offer_id' => $offerId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find the offer to delete.'));
        $resultRedirect->setPath('customoffer/index');
        return $resultRedirect;
    }
}