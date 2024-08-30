<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Controller\Front;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\JsonFactory;
use Coditron\Notifications\Model\ResourceModel\NotificationSend\CollectionFactory as NotificationSendCollectionFactory;

class UpdateStatus extends Action
{
    protected $customerSession;
    protected $notificationSendCollectionFactory;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        Session $customerSession,
        JsonFactory $resultJsonFactory,
        NotificationSendCollectionFactory $notificationSendCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->notificationSendCollectionFactory = $notificationSendCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {


        $result = $this->resultJsonFactory->create();
        $data = $this->getRequest()->getParams();

        $customerId = $this->customerSession->getCustomerId();
        $notificationId = isset($data['notificationsend_id']) ? $data['notificationsend_id'] : null;

        $collection = $this->notificationSendCollectionFactory->create();
        $collection->addFieldToFilter('notificationsend_id', $notificationId);
        $collection->addFieldToFilter('customer_id', $customerId);
        $notification = $collection->getFirstItem();

        if ($collection->getSize() > 0) {
            foreach ($collection as $notification) {
                // Set status to read
                $notification->setStatus('read'); 
                $notification->save();
            }
            return $result->setData([
                'success' => true,
                'message' => 'Notification status updated successfully.'
            ]);
        }

        return $result->setData([
            'success' => false,
            'message' => 'Notification not found.'
        ]);
    }
}