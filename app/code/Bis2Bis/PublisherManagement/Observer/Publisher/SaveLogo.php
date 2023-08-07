<?php

namespace Bis2Bis\PublisherManagement\Observer\Publisher;

use Bis2Bis\PublisherManagement\Model\Publisher;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Bis2Bis\PublisherManagement\Model\ImageUploader;

class SaveLogo implements ObserverInterface
{
    public function __construct(private readonly ImageUploader $imageUploader)
    {
    }

    /**
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        /** @var Publisher $publisher */
        $publisher = $observer->getData('model');

        if (!isset($publisher['logo']) || empty($publisher['logo'])) {
            return;
        }

        $publisher['logo'] = $this->imageUploader->moveFileFromTmp($publisher['logo'][0]['name']);
    }
}
