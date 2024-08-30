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
use Coditron\Notifications\Model\NotificationOutOfStockFactory;

class OutofStock extends Action
{
    protected $customerSession;
    protected $resultJsonFactory;
    protected $notificationOutOfStockFactory;

    public function __construct(
        Context $context,
        Session $customerSession,
        JsonFactory $resultJsonFactory,
        NotificationOutOfStockFactory $notificationOutOfStockFactory
    ) {
        $this->customerSession = $customerSession;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->notificationOutOfStockFactory = $notificationOutOfStockFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        try {
            $customer = $this->customerSession->getCustomer();
            $customerId = $customer->getId();
            $productId = $this->getRequest()->getParam('product_id');
            $productName = $this->getRequest()->getParam('product_name');

            $notification = $this->notificationOutOfStockFactory->create();
            $notification->setCustomerId($customerId);
            $notification->setProductId($productId);
            $notification->setProductName($productName);

            $notification->save();

            $result->setData(['success' => true, 'message' => __('Notification has been saved.')]);
        } catch (\Exception $e) {
            $result->setData(['success' => false, 'message' => __('Unable to save notification.')]);
        }

        return $result;
    }
}
