<?php

namespace Bis2Bis\PublisherManagement\Controller\Adminhtml\Publisher;

use Bis2Bis\PublisherManagement\Model\PublisherFactory;
use Bis2Bis\PublisherManagement\Repository\PublisherRepository;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Authorization;

class Save implements ActionInterface
{
    /**
     * @param RedirectFactory $redirectFactory
     * @param PublisherFactory $publisherFactory
     * @param RequestInterface $request
     * @param PublisherRepository $publisherRepository
     * @param ManagerInterface $messageManager
     * @param Authorization $authorization
     */
    public function __construct(
        private readonly RedirectFactory $redirectFactory,
        private readonly PublisherFactory $publisherFactory,
        private readonly RequestInterface $request,
        private readonly PublisherRepository $publisherRepository,
        private readonly ManagerInterface $messageManager,
        private readonly Authorization $authorization
    ) {
    }

    public function execute(): ResultInterface|ResponseInterface|Redirect
    {
        try {
            $publisher = $this->publisherFactory->create()
                ->setData($this->request->getParam('general'));

            $this->publisherRepository->save($publisher);

            $this->messageManager->addSuccessMessage(__('Publisher created.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->redirectFactory->create()->setPath('bis2bis/publisher');
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Bis2Bis_PublisherManagement::add_publisher');
    }
}
