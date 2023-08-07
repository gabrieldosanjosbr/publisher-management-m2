<?php

namespace Bis2Bis\PublisherManagement\Model;

use Magento\Framework\Model\AbstractModel;
use Bis2Bis\PublisherManagement\Api\Data\PublisherInterface;
use Bis2Bis\PublisherManagement\Model\ResourceModel\Publisher as PublisherResource;

class Publisher extends AbstractModel implements PublisherInterface
{
    const LOGO_PATH = "publisher/logo";

    protected function _construct()
    {
        $this->_init(PublisherResource::class);
    }
}
