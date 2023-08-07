<?php

namespace Bis2Bis\PublisherManagement\Repository;

use Bis2Bis\PublisherManagement\Api\Data\PublisherInterface;
use Bis2Bis\PublisherManagement\Model\Publisher;
use Bis2Bis\PublisherManagement\Model\ResourceModel\Publisher as PublisherResource;
use Bis2Bis\PublisherManagement\Model\PublisherFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;

class PublisherRepository
{
    public function __construct(
        private readonly PublisherFactory $publisherFactory,
        private readonly PublisherResource $publisher,
        private readonly EventManager $eventManager
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function getById($id): Publisher
    {
        $publisher = $this->publisherFactory->create();

        $this->publisher->load($publisher, $id, 'publisher_id');

        if ($publisher->isEmpty()) {
            throw new NotFoundException(__('Publisher not found.'));
        }

        return $publisher;
    }

    /**
     * @throws LocalizedException
     */
    public function save(PublisherInterface $model): bool
    {
        $eventData = ['model' => $model];

        try {
            $this->eventManager->dispatch('bis2bis_publishermanagement_publisher_created_before', $eventData);
            $this->publisher->save($model);
            $this->eventManager->dispatch('bis2bis_publishermanagement_publisher_created_after', $eventData);
        } catch (\Exception $e) {
           throw new LocalizedException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * @throws LocalizedException
     */
    public function delete(PublisherInterface $model): bool
    {
        $eventData = ['model' => $model];

        try {
            $this->eventManager->dispatch('bis2bis_publishermanagement_publisher_deleted_before', $eventData);
            $this->publisher->delete($model);
            $this->eventManager->dispatch('bis2bis_publishermanagement_publisher_deleted_after', $eventData);
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        return true;
    }
}
