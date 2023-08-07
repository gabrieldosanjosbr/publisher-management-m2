<?php

namespace Bis2Bis\PublisherManagement\Controller\Adminhtml\Publisher;

use Bis2Bis\PublisherManagement\Model\ImageUploader;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Authorization;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\Page;

class UploadLogo implements ActionInterface
{
    /**
     * @param Authorization $authorization
     * @param JsonFactory $jsonFactory
     * @param ImageUploader $imageUploader
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(
        private readonly Authorization $authorization,
        private readonly JsonFactory $jsonFactory,
        private readonly ImageUploader $imageUploader,
        private readonly SessionManagerInterface $sessionManager
    ) {
    }

    public function execute(): Page|ResultInterface|ResponseInterface
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('general[logo]');
            $result['cookie'] = [
                'name' => $this->sessionManager->getName(),
                'value' => $this->sessionManager->getSessionId(),
                'lifetime' => $this->sessionManager->getCookieLifetime(),
                'path' => $this->sessionManager->getCookiePath(),
                'domain' => $this->sessionManager->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        $resultJson = $this->jsonFactory->create();

        return $resultJson->setData($result);
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Bis2Bis_PublisherManagement::publisher');
    }
}
