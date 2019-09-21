<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml\Index;

class Edit extends \BroSolutions\CustomOffer\Controller\Adminhtml\CustomOffer
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('BroSolutions_CustomOffer::offer')
            ->addBreadcrumb(__('Offers'), __('Offers'))
            ->addBreadcrumb(__('Manage Offers'), __('Manage Offers'));
        $resultPage->addBreadcrumb(
            __('offer'),
            __(sprintf('offer: #%s', $this->getRequest()->getParam('offer_id')))
        );
        $resultPage->getConfig()->getTitle()->prepend(
            __(sprintf('offer: #%s', $this->getRequest()->getParam('offer_id')))
        );
        return $resultPage;
    }
}