<?php

namespace Bis2Bis\PublisherManagement\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ImageUploader
{
    protected WriteInterface $mediaDirectory;

    /**
     * @throws FileSystemException
     */
    public function __construct(
        Filesystem                             $filesystem,
        private readonly Database              $coreFileStorageDatabase,
        private readonly UploaderFactory       $uploaderFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly LoggerInterface       $logger,
        private readonly string                $baseTmpPath = "bis2bis/tmp/image",
        private readonly string                $basePath = "bis2bis/image",
        private readonly array                 $allowedExtensions = ['jpg', 'jpeg', 'png']
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * @throws LocalizedException
     */
    public function moveFileFromTmp($imageName)
    {
        $baseImagePath = $this->getFilePath($this->basePath, $imageName);
        $baseTmpImagePath = $this->getFilePath($this->baseTmpPath, $imageName);

        try {
            $this->coreFileStorageDatabase->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (\Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }
        return $imageName;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function saveFileToTmpDir($fileId): bool|array
    {
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->allowedExtensions);
        $uploader->setAllowRenameFiles(true);

        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($this->baseTmpPath));

        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $result['path']);
        $result['url'] = sprintf(
            '%s%s',
            $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
            $this->getFilePath($this->baseTmpPath, $result['file'])
        );

        $result['name'] = $result['file'];

        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($this->baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }

    private function getFilePath($path, $imageName): string
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }
}
