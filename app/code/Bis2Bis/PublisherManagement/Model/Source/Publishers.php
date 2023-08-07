<?php

namespace Bis2Bis\PublisherManagement\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Bis2Bis\PublisherManagement\Model\ResourceModel\Publisher\CollectionFactory;

class Publishers extends AbstractSource
{
    public function __construct(private readonly CollectionFactory $collectionFactory)
    {
    }

    public function getAllOptions(): ?array
    {
        if (!$this->_options) {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('status', ['eq' => true]);

            $options = [['value' => '', 'label' => __('Select an option...')]];
            foreach ($collection as $item) {
                $options[] = [
                    'value' => $item->getId(),
                    'label' => $item->getName(),
                ];
            }

            $this->_options = $options;
        }

        return $this->_options;
    }
}
