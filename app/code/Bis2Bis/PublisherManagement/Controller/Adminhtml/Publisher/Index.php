<?php

namespace Bis2Bis\PublisherManagement\Controller\Adminhtml\Publisher;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Authorization;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements ActionInterface
{
    public function __construct(
        private readonly PageFactory $pageFactory,
        private readonly Authorization $authorization
    ) {
    }

    public function execute(): Page|ResultInterface|ResponseInterface
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Publisher List'));

        return $resultPage;
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Bis2Bis_PublisherManagement::publisher');
    }

}
