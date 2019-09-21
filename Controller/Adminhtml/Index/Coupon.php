<?php

namespace BroSolutions\CustomOffer\Controller\Adminhtml\Index;

class Coupon extends \Magento\Backend\App\Action
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
     * @var \Magento\Framework\App\StateFactory
     */
    protected $state;


    protected $rule;


    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $searchCriteriaBuilderFactory;

    protected $searchCriteriaBuilder;

    /**
     * Coupon constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \BroSolutions\CustomOffer\Api\Data\OfferInterfaceFactory $offerInterfaceFactory
     * @param \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository
     * @param \Magento\Framework\App\StateFactory $state
     * @param \Magento\SalesRule\Model\RuleFactory $rule
     * @param \Magento\Framework\Api\Search\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \BroSolutions\CustomOffer\Api\Data\OfferInterfaceFactory $offerInterfaceFactory,
        \BroSolutions\CustomOffer\Api\OfferRepositoryInterface $offerRepository,
        \Magento\Framework\App\StateFactory $state,
        \Magento\SalesRule\Model\RuleFactory $rule,
        \Magento\Framework\Api\Search\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {

        $this->dataPersistor = $dataPersistor;
        $this->offerInterfaceFactory = $offerInterfaceFactory;
        $this->offerRepository = $offerRepository;
        $this->state = $state;
        $this->rule = $rule;
        $this->searchCriteriaBuilder  = $searchCriteriaBuilder;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;

        parent::__construct($context);
    }


    private function generateString($strength)
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
    private function setPercentCoupon()
    {
        $productId = $this->getRequest()->getParam('offer_id');
        $searchCriteria = $this->searchCriteriaBuilderFactory->create();
        $_filter = $this->searchCriteriaBuilder->addFilter("offer_id", "$productId", "like")->create();
        $products = $this->offerRepository->getList($_filter);
        foreach ($products->getItems() as $product) {
            return round($product['price_difference'], 0);
        }
    }

    private function setEmailForCoupon()
    {
        $productId = $this->getRequest()->getParam('offer_id');
        $searchCriteria = $this->searchCriteriaBuilderFactory->create();
        $_filter = $this->searchCriteriaBuilder->addFilter("offer_id", "$productId", "like")->create();
        $products = $this->offerRepository->getList($_filter);
        foreach ($products->getItems() as $product) {
            return $product['email'];
        }
    }

    public function execute()
    {
        $this->setPercentCoupon();
        $resultRedirect = $this->resultRedirectFactory->create();
        $state = $this->state;
        $coupon['name'] = 'Brothers Coupon';
        $coupon['desc'] = 'Discount for customer email ' .$this->setEmailForCoupon(). ' coupon.';
        $coupon['start'] = date('Y-m-d');
        $coupon['end'] = date("Y-m-d", strtotime("+ 30 day"));
        $coupon['max_redemptions'] = 1;
        $coupon['discount_type'] = 'by_percent';
        $coupon['discount_amount'] = $this->setPercentCoupon();
        $coupon['flag_is_free_shipping'] = 'no';
        $coupon['redemptions'] = 1;
        $coupon['code'] = 'BRO_'.$this->generateString(5);

        $shoppingCartPriceRule = $this->rule->create();
        $shoppingCartPriceRule->setName($coupon['name'])
            ->setDescription($coupon['desc'])
            ->setFromDate($coupon['start'])
            ->setToDate($coupon['end'])
            ->setUsesPerCustomer($coupon['max_redemptions'])
            ->setCustomerGroupIds(array('0', '1', '2', '3',))
            ->setIsActive(1)
            ->setSimpleAction($coupon['discount_type'])
            ->setDiscountAmount($coupon['discount_amount'])
            ->setDiscountQty(1)
            ->setApplyToShipping($coupon['flag_is_free_shipping'])
            ->setTimesUsed($coupon['redemptions'])
            ->setWebsiteIds(array('1'))
            ->setCouponType(2)
            ->setCouponCode($coupon['code'])
            ->setUsesPerCoupon(NULL);
        $shoppingCartPriceRule->save();

        $resultRedirect->setPath('customoffer/index/');
        return $resultRedirect->setPath('*/*/');
    }

}
