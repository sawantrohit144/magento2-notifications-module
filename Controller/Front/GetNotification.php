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

class GetNotification extends Action
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

        $customer = $this->customerSession->getCustomer();
        $customerId = $customer->getId();

        $collection = $this->notificationSendCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId);

        $notifications = $collection->getItems();

        $currentDateTime = date('Y-m-d H:i:s');
        $notificationData = [];
        
        foreach ($notifications as $notification) {
            $fromDate = $notification->getFromDate();
            $toDate = $notification->getToDate();
            
            if ($fromDate <= $currentDateTime && $toDate >= $currentDateTime) {
                $notificationData[] = [
                    'notificationsend_id' => $notification->getNotificationSendId(),
                    'message' => $notification->getMessage(),
                    'status' => $notification->getStatus()
                ];
            }
        }

        return $result->setData([
            'success' => true,
            'notifications' => $notificationData
        ]);
    }
}
