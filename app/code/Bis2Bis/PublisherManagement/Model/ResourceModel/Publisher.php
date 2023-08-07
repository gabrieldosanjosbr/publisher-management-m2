<?php

namespace Bis2Bis\PublisherManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Publisher extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('bis2bis_publisher', 'publisher_id');
    }
}
