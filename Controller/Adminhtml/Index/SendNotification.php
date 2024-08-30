<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Coditron\Notifications\Model\ResourceModel\Notification\CollectionFactory as NotificationCollectionFactory;
use Coditron\Notifications\Model\ResourceModel\NotificationSend\CollectionFactory as NotificationSendCollectionFactory;
use Coditron\Notifications\Model\NotificationSendFactory;

class SendNotification extends Action
{
    protected $customerRepository;
    protected $customerCollectionFactory;
    protected $notificationCollectionFactory;
    protected $notificationSendFactory;
    protected $notificationSendCollectionFactory;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        CustomerCollectionFactory $customerCollectionFactory,
        NotificationCollectionFactory $notificationCollectionFactory,
        NotificationSendFactory $notificationSendFactory,
        NotificationSendCollectionFactory $notificationSendCollectionFactory
    ) {
        parent::__construct($context);
        $this->customerRepository = $customerRepository;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->notificationSendFactory = $notificationSendFactory;
        $this->notificationSendCollectionFactory = $notificationSendCollectionFactory;
    }

    public function execute()
    {
        $customerIds = $this->getRequest()->getParam('selected', []);
        $notificationIds = $this->getRequest()->getParam('notification_id', []);

        $customersData = [];
        $customersUpdated = 0;

        if (empty($customerIds)) {
            // If all customers are selected
            $customerCollection = $this->customerCollectionFactory->create();
            foreach ($customerCollection as $customer) {
                $customersData[] = [
                    'id' => $customer->getId(),
                    'email' => $customer->getEmail(),
                    'firstname' => $customer->getFirstname(),
                    'lastname' => $customer->getLastname(),
                ];
                // Include all customer IDs
                $customerIds[] = $customer->getId(); 
                $customersUpdated++;
            }
        } else {
            // If multi customers are selected
            foreach ($customerIds as $customerId) {
                try {
                    $customer = $this->customerRepository->getById((int)$customerId);
                    $customersData[] = [
                        'id' => $customer->getId(),
                        'email' => $customer->getEmail(),
                    ];
                } catch (\Exception $e) {
                }
                $customersUpdated++;
            }
        }

        $notificationCollection = $this->notificationCollectionFactory->create()
        ->addFieldToFilter('notification_id', ['in' => $notificationIds]);

        
        foreach ($notificationCollection as $notification) {
            foreach ($customerIds as $customerId) {
                // Check if the notification already exists for the customer
                $existingNotification = $this->notificationSendCollectionFactory->create()
                    ->addFieldToFilter('notification_id', $notification->getNotificationId())
                    ->addFieldToFilter('customer_id', $customerId)
                    ->getFirstItem();

                if ($existingNotification->getId()) {
                    // Notification already exists, skip saving
                    continue;
                }

                $sendNotification = $this->notificationSendFactory->create();
                $sendNotification->setData([
                    'notification_id' => $notification->getNotificationId(),
                    'customer_id' => $customerId,
                    'message' => $notification->getDescription(),
                    'from_date' => $notification->getFromDate(),
                    'to_date' => $notification->getToDate()
                ]);
                $sendNotification->save();
            }
        }

        if ($customersUpdated) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were updated.', $customersUpdated));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->_redirect->getRefererUrl());

        return $resultRedirect;
    }
}
