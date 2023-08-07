<?php

namespace Bis2Bis\PublisherManagement\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Action extends Column
{
    const PUBLISHER_URL_PATH_EDIT = 'bis2bis/publisher/edit';
    const PUBLISHER_URL_PATH_DELETE = 'bis2bis/publisher/delete';

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (!isset($item['publisher_id'])) {
                    continue;
                }

                $name = $this->getData('name');

                $item[$name]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        self::PUBLISHER_URL_PATH_EDIT,
                        ['id' => $item['publisher_id']]
                    ),
                    'label' => __('Edit'),
                ];

                $item[$name]['delete'] = [
                    'href' => $this->urlBuilder->getUrl(
                        self::PUBLISHER_URL_PATH_DELETE,
                        ['id' => $item['publisher_id']]
                    ),
                    'label' => __('Delete'),
                ];
            }
        }

        return $dataSource;
    }
}
