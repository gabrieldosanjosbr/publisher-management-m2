<?php

namespace Bis2Bis\PublisherManagement\Model\ResourceModel\Publisher;

use Bis2Bis\PublisherManagement\Model\Publisher;
use Bis2Bis\PublisherManagement\Model\ResourceModel\Publisher as PublisherResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'publisher_id';
    protected $_eventPrefix = 'bis2bis_publishermanagement_publisher_collection';
    protected $_eventObject = 'publisher_collection';

    protected function _construct()
    {
        $this->_init(Publisher::class,PublisherResource::class);
    }
}
