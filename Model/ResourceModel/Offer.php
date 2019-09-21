<?php

namespace BroSolutions\CustomOffer\Model\ResourceModel;

class Offer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    const TABLE_NAME = 'brosolutions_customoffer_offer';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(self::TABLE_NAME, \BroSolutions\CustomOffer\Api\Data\OfferInterface::OFFER_ID);
    }
}