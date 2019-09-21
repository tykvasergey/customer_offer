<?php

namespace BroSolutions\CustomOffer\Model;

class Offer extends \Magento\Framework\Model\AbstractModel implements \BroSolutions\CustomOffer\Api\Data\OfferInterface
{
    const CACHE_TAG = 'brosolutions_customoffer_offer';

    /**#@+
     * Offer's statuses
     */
    const OFFER_STATUS_ENABLED = 1;
    const OFFER_STATUS_DISABLED = 0;
    /**
     * Offer constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
        /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('BroSolutions\CustomOffer\Model\ResourceModel\Offer');
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::OFFER_ID);
    }


    /**
     * @param mixed|string $Id
     *
     * @return $this|\Magento\Framework\Model\AbstractModel|mixed
     */
    public function setId($Id)
    {
        $this->setData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::OFFER_ID, $Id);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->getData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::EMAIL);
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function setEmail(string $email)
    {
        $this->setData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::EMAIL, $email);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnotherStoreLink()
    {
        return $this->getData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::ANOTHER_STORE_LINK);
    }

    /**
     * @param string $anotherStoreLink
     *
     * @return mixed
     */
    public function setAnotherStoreLink(string $anotherStoreLink)
    {
        $this->setData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::ANOTHER_STORE_LINK, $anotherStoreLink);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYourPrice()
    {
        return $this->getData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::YOUR_PRICE);
    }

    /**
     * @param string $yourPrice
     *
     * @return mixed
     */
    public function setYourPrice(string $yourPrice)
    {
        $this->setData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::YOUR_PRICE, $yourPrice);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->getData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::QTY);
    }

    /**
     * @param string $qty
     *
     * @return mixed
     */
    public function setQty($qty)
    {
        $this->setData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::QTY, $qty);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->getData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::PRODUCT_ID);
    }

    /**
     * @param string $productId
     *
     * @return mixed
     */
    public function setProductId($productId)
    {
        $this->setData(\BroSolutions\CustomOffer\Api\Data\OfferInterface::PRODUCT_ID, $productId);
        return $this;
    }

    public function getAvailableStatuses()
    {
        return [self::OFFER_STATUS_ENABLED => __('Answered'), self::OFFER_STATUS_DISABLED => __('In process')];
    }
}