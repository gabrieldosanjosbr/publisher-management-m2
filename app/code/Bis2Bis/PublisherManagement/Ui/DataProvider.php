<?php

namespace Bis2Bis\PublisherManagement\Ui;

use Bis2Bis\PublisherManagement\Model\Publisher;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem;

class DataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collectionFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly Filesystem $filesystem,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        if (!$collectionFactory) {
            return;
        }

        $this->collection = $collectionFactory->create();
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getData(): array
    {
        $result = [];

        if (!$this->collection) {
            return $result;
        }

        foreach ($this->collection->getItems() as $item) {
            $result[$item->getId()]['general'] = $item->getData();

            if (!$item['logo']) {
                continue;
            }

            $result[$item->getId()]['general']['logo'] = [[
                'name' => $item['logo'],
                'url' => $this->getLogoUrl($item['logo']),
                'size' => filesize($this->getLogoMediaPath($item['logo'])),
                'type' => 'image'
            ]];
        }

        return $result;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getLogoUrl($fileName): string
    {
        return sprintf('%s%s/%s',
            $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
            Publisher::LOGO_PATH,
            $fileName
        );
    }

    public function getLogoMediaPath($filename): string
    {
        return sprintf(
            '%s%s/%s',
            $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(),
            Publisher::LOGO_PATH,
            $filename
        );
    }
}
