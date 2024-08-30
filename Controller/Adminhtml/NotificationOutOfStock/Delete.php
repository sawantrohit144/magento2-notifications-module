<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Controller\Adminhtml\NotificationOutOfStock;

class Delete extends \Coditron\Notifications\Controller\Adminhtml\NotificationOutOfStock
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('notificationoutofstock_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Coditron\Notifications\Model\NotificationOutOfStock::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Notificationoutofstock.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['notificationoutofstock_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Notificationoutofstock to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}