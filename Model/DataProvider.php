<?php

namespace BroSolutions\CustomOffer\Model;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface
     */
    protected $pool;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory $offerCollectionFactory
     * @param \Magento\Ui\DataProvider\Modifier\PoolInterface $pool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \BroSolutions\CustomOffer\Model\ResourceModel\Offer\CollectionFactory $offerCollectionFactory,
        \Magento\Ui\DataProvider\Modifier\PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection   = $offerCollectionFactory->create();
        $this->pool         = $pool;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        $meta = parent::getMeta();
        /** @var \Magento\Ui\DataProvider\Modifier\ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }
        return $meta;
    }

    public function getData()
    {
        /** @var \Magento\Ui\DataProvider\Modifier\ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }
        return $this->data;
    }
}