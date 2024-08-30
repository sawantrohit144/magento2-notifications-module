<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Coditron\Notifications\Model\ResourceModel\NotificationOutOfStock\CollectionFactory as NotificationCollectionFactory;
use Coditron\Notifications\Model\NotificationSendFactory;

class ProductUpdateObserver implements ObserverInterface
{
    protected $stockRegistry;
    protected $notificationCollectionFactory;
    protected $notificationSendFactory;

    public function __construct(
        StockRegistryInterface $stockRegistry,
        NotificationCollectionFactory $notificationCollectionFactory,
        NotificationSendFactory $notificationSendFactory
    ) {
        $this->stockRegistry = $stockRegistry;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->notificationSendFactory = $notificationSendFactory;
    }

    public function execute(Observer $observer)
    {

        // Get the product from the event observer
        $product = $observer->getEvent()->getProduct();
        $productId = $product->getId();
        
        $stockItem = $this->stockRegistry->getStockItem($productId);

        if ($stockItem->getQty() > 0) {
            $notificationCollection = $this->notificationCollectionFactory->create()
                ->addFieldToFilter('product_id', $productId)
                ->addFieldToFilter('status', 'pending');
            $fromDate = date('Y-m-d H:i:s');

            foreach ($notificationCollection as $notification) {
                $toDate = (new \DateTime($fromDate))->modify('+1 day')->format('Y-m-d H:i:s');
                
                $notificationSend = $this->notificationSendFactory->create();
                $notificationSend->setData([
                    'customer_id' =>  $notification->getCustomerId(),
                    'message' => __('The product ' . $product->getName() . ' is now in stock.'),
                    'from_date' => $fromDate,
                    'to_date' => $toDate
                ]);
                // Set status to send
                $notification->setStatus('send'); 
                $notification->save();

                $notificationSend->save();
            }
        }
    }
}
