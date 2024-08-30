<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Model\Config\Backend;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Config\Model\Config\Backend\Image as BackendImage;
use Magento\Framework\Exception\LocalizedException;

class BellIcon extends BackendImage
{
    const UPLOAD_DIR = 'bell_icon'; // Directory name for uploaded files
    const UPLOAD_ROOT_DIR = DirectoryList::MEDIA;

    /**
     * Return path to directory for upload
     *
     * @return string
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath(self::UPLOAD_DIR);
    }

    /**
     * Return path to directory for upload
     *
     * @return string
     */
    protected function _getUploadRootDir()
    {
        return $this->_mediaDirectory->getAbsolutePath(self::UPLOAD_ROOT_DIR);
    }

    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return string[]
     */
    protected function _getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }

    /**
     * Add validators for uploaded file
     *
     * @throws LocalizedException
     */
    protected function _addValidators()
    {
        parent::_addValidators();
        $this->addValidator(new \Magento\Framework\Validator\File\Image());
    }

    /**
     * Make upload directory
     *
     * @param string $uploadDir
     * @return string
     */
    protected function _createUploadDir($uploadDir)
    {
        if (!$this->_file->isExists($uploadDir)) {
            $this->_file->createDirectory($uploadDir);
        }
        return $uploadDir;
    }

    /**
     * Save uploaded file and set its name to model
     *
     * @return $this
     * @throws LocalizedException
     */
    public function beforeSave()
    {

        $value = $this->getValue();
        
        if ($value) {
            if (isset($value['delete']) && $value['delete']) {
                $this->setValue('');
                return $this;
            }

            if (isset($value[0]['name']) && isset($value[0]['tmp_name'])) {
                try {
                    $uploader = $this->_uploaderFactory->create(['fileId' => $this->getFieldsetDataValue('bell_icon')]);
                    $uploader->setAllowedExtensions($this->_getAllowedExtensions());
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);

                    $uploadDir = $this->_getUploadDir();
                    $result = $uploader->save($uploadDir);

                    if (!$result) {
                        throw new LocalizedException(__('File cannot be saved to path: %1', $uploadDir));
                    }

                    $relativePath = self::UPLOAD_DIR . '/' . $result['file'];

                    $this->setValue($relativePath);
                } catch (\Exception $e) {
                    throw new LocalizedException(__('File upload error: %1', $e->getMessage()));
                }
            } else {
                if (isset($value['value'])) {
                    // Remove 'default/' prefix if present
                    $relativePath = str_replace('default/', '', $value['value']);
                    $this->setValue($relativePath);
                }
            }
        }

        return parent::beforeSave();
    }

    /**
     * After load method to correct the path value
     */
    public function afterLoad()
    {
        $value = $this->getValue();

        if ($value && strpos($value, 'default/') !== false) {
            $correctedValue = str_replace('default/', '', $value);
            $this->setValue($correctedValue);
        }

        return parent::afterLoad();
    }
}
