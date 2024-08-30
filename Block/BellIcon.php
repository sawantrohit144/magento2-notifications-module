<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Block;

use Magento\Framework\View\Element\Template;
use Coditron\Notifications\Helper\Data;
use Magento\Customer\Model\Session;
use Coditron\Notifications\Model\ResourceModel\NotificationSend\CollectionFactory as NotificationSendCollectionFactory;

class BellIcon extends Template
{
    protected $helper;
    protected $customerSession;
    protected $notificationSendCollectionFactory;

    public function __construct(
        Template\Context $context,
        Data $helper,
        Session $customerSession,
        NotificationSendCollectionFactory $notificationSendCollectionFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        $this->notificationSendCollectionFactory = $notificationSendCollectionFactory;
        parent::__construct($context, $data);
    }

    public function isBellIconEnabled()
    {
        return $this->helper->isBellIconEnabled();
    }

    public function isCustLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function getBellIconUrl()
    {
        return $this->helper->getBellIconUrl();
    }

    public function getCustomerId(){
        
        $id = $this->customerSession->getCustomer()->getId();
        return $id;
    }

    public function getUnreadNotificationCount()
    {
        if (!$this->isCustLoggedIn()) {
            return [];
        }
        
        $customerId = $this->customerSession->getCustomerId();
        $currentDateTime = (new \DateTime())->format('Y-m-d H:i:s');
        
        $collection = $this->notificationSendCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->addFieldToFilter('status', 'unread');
        $collection->addFieldToFilter('from_date', ['lteq' => $currentDateTime]);
        $collection->addFieldToFilter('to_date', ['gteq' => $currentDateTime]);
        
        return $collection->getSize();
    }    
}
