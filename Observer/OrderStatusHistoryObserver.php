<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Coditron\Notifications\Model\NotificationSendFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

class OrderStatusHistoryObserver implements ObserverInterface
{
    protected $notificationSendFactory;
    protected $scopeConfig;
    protected $orderCollectionFactory;

    public function __construct(
        NotificationSendFactory $notificationSendFactory,
        ScopeConfigInterface $scopeConfig,
        OrderCollectionFactory $orderCollectionFactory
    ) {
        $this->notificationSendFactory = $notificationSendFactory;
        $this->scopeConfig = $scopeConfig;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function execute(Observer $observer)
    {
        $isEnabled = $this->scopeConfig->getValue('bell_icon/notifications/notify_on_shipped', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$isEnabled) {
            return;
        }

        // Get the order object from the event
        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();
        $orderId = $order->getId();

        // Retrieve product names from the order
        $productNames = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $productNames[] = $item->getName();
        }

        $productNamesString = implode(', ', $productNames);
        $customMessage = "Your order has been shipped! The following items are on their way: " . $productNamesString;

        // Check if the current order status is 'Complete'
        if ($order->getStatus() == 'complete') {
            $fromDate = date('Y-m-d H:i:s');

            $orderCollection = $this->orderCollectionFactory->create()
                ->addFieldToFilter('customer_id', $customerId)
                ->addFieldToFilter('created_at', $order->getCreatedAt());

            if ($orderCollection->getSize() > 0) {
                $toDate = (new \DateTime($fromDate))->modify('+1 day')->format('Y-m-d H:i:s');

                $notificationSend = $this->notificationSendFactory->create();
                $notificationSend->setData([
                    'customer_id' => $customerId,
                    'message' => $customMessage,
                    'status' => 'unread',
                    'from_date' => $fromDate,
                    'to_date' => $toDate
                ]);
                $notificationSend->save();
            } 
        } 
    }
}
