<?php

namespace Bis2Bis\PublisherManagement\Controller\Adminhtml\Publisher;

use Bis2Bis\PublisherManagement\Repository\PublisherRepository;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Authorization;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\Page;


class Delete implements ActionInterface
{
    /**
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param PublisherRepository $publisherRepository
     * @param Authorization $authorization
     */
    public function __construct(
        private readonly ResultFactory $resultFactory,
        private readonly RequestInterface $request,
        private readonly ManagerInterface $messageManager,
        private readonly PublisherRepository $publisherRepository,
        private readonly Authorization $authorization
    ) {
    }

    public function execute(): Page|ResultInterface|ResponseInterface
    {
        $publisherId = (int) $this->request->getParam('id');

        try {
            $publisher = $this->publisherRepository->getById($publisherId);

            $this->publisherRepository->delete($publisher);

            $this->messageManager->addSuccessMessage(__('Publisher deleted successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('bis2bis/publisher');
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Bis2Bis_PublisherManagement::delete_publisher');
    }
}
