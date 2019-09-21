<?php

namespace BroSolutions\CustomOffer\Api;

interface OfferRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function get(int $id);


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);


    /**
     * @param \BroSolutions\CustomOffer\Api\Data\OfferInterface $offer
     *
     * @return mixed
     */
    public function save(\BroSolutions\CustomOffer\Api\Data\OfferInterface $offer);


    /**
     * @param \BroSolutions\CustomOffer\Api\Data\OfferInterface $offer
     *
     * @return mixed
     */
    public function delete(\BroSolutions\CustomOffer\Api\Data\OfferInterface $offer);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}