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
use Magento\Framework\Exception\LocalizedException;

class SaveDataObserver implements ObserverInterface
{
    protected $notificationSendFactory;
    protected $scopeConfig;

    public function __construct(
        NotificationSendFactory $notificationSendFactory,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->notificationSendFactory = $notificationSendFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        $isEnabled = $this->scopeConfig->getValue('bell_icon/notifications/notify_on_order', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$isEnabled) {
            return;
        }

        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();
        $customerFromDate = date('Y-m-d H:i:s');
        $customerToDate = (new \DateTime($customerFromDate))->modify('+1 day')->format('Y-m-d H:i:s');

        // Get product names from the order
        $productNames = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $productNames[] = $item->getName();
        }

        $productNamesStr = implode(', ', $productNames);
        $finalMessage = 'Thank you for your purchase! Your order ' . $productNamesStr .' has been placed successfully!';

        $notificationSend = $this->notificationSendFactory->create();
        $notificationSend->setData([
            'customer_id' =>  $customerId,
            'message' => $finalMessage,
            'from_date' =>  $customerFromDate,
            'to_date' =>  $customerToDate
        ]);

        try {
            $notificationSend->save();
        } catch (\Exception $e) {
            // Throw a localized exception with the error message
            throw new LocalizedException(__('Unable to save notification: %1', $e->getMessage()));
        }
    }
}
