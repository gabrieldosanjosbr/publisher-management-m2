<?php

namespace Bis2Bis\PublisherManagement\Ui\Component\Listing\Column;

use Bis2Bis\PublisherManagement\Model\Publisher;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach($dataSource['data']['items'] as &$item) {
            $url = '';
            if($item[$fieldName] != '') {
                $url = sprintf('%s%s/%s',
                    $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
                    Publisher::LOGO_PATH,
                    $item[$fieldName]
                );
            }

            $item[$fieldName . '_src'] = $url;
            $item[$fieldName . '_orig_src'] = $url;
        }

        return $dataSource;
    }
}
