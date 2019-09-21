<?php

namespace BroSolutions\CustomOffer\Api\Data;

interface OfferInterface
{
    const OFFER_ID = 'offer_id';
    const PRODUCT_ID = 'product_id';
    const EMAIL = 'email';
    const ANOTHER_STORE_LINK = 'another_store_link';
    const YOUR_PRICE = 'your_price';
    const QTY = 'qty';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getProductId();

    /**
     * @param string $productId
     *
     * @return mixed
     */
    public function setProductId($productId);
    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function setEmail(string $email);

    /**
     * @return mixed
     */
    public function getAnotherStoreLink();

    /**
     * @param string $anotherStoreLink
     *
     * @return mixed
     */
    public function setAnotherStoreLink(string $anotherStoreLink);

    /**
     * @return mixed
     */
    public function getYourPrice();

    /**
     * @param string $yourPrice
     *
     * @return mixed
     */
    public function setYourPrice(string $yourPrice);

    /**
     * @return mixed
     */
    public function getQty();

    /**
     * @param string $qty
     *
     * @return mixed
     */
    public function setQty($qty);

}