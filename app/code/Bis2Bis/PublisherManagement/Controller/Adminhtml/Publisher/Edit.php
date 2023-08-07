<?php

namespace Bis2Bis\PublisherManagement\Controller\Adminhtml\Publisher;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Authorization;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit implements ActionInterface
{
    /**
     * @param Authorization $authorization
     * @param PageFactory $pageFactory
     */
    public function __construct(
        private readonly Authorization $authorization,
        private readonly PageFactory $pageFactory
    ) {
    }

    public function execute(): Page|ResultInterface|ResponseInterface
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Publisher'));

        return $resultPage;
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Bis2Bis_PublisherManagement::edit_publisher');
    }
}
