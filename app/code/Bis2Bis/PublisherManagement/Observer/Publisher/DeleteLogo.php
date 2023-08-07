<?php

namespace Bis2Bis\PublisherManagement\Observer\Publisher;

use Bis2Bis\PublisherManagement\Model\Publisher;
use Bis2Bis\PublisherManagement\Ui\DataProvider;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class DeleteLogo implements ObserverInterface
{
    public function __construct(private readonly DataProvider $dataProvider)
    {
    }

    public function execute(Observer $observer)
    {
        /** @var Publisher $publisher */
        $publisher = $observer->getData('model');

        if (!$publisher->isDeleted() || !$publisher['logo']) {
            return;
        }

        $logoPath = $this->dataProvider->getLogoMediaPath($publisher['logo']);

        if (!file_exists($logoPath)) {
            return;
        }

        unlink($logoPath);
    }
}
