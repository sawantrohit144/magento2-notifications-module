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
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\SalesRule\Model\ResourceModel\Coupon\CollectionFactory as CouponCollectionFactory;
use Coditron\Notifications\Model\NotificationSendFactory;

class AllowedNotification extends Action
{
    protected $customerRepository;
    protected $customerCollectionFactory;
    protected $notificationSendFactory;
    protected $couponCollectionFactory;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        CustomerCollectionFactory $customerCollectionFactory,
        NotificationSendFactory $notificationSendFactory,
        CouponCollectionFactory $couponCollectionFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->customerRepository = $customerRepository;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->notificationSendFactory = $notificationSendFactory;
        $this->couponCollectionFactory = $couponCollectionFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $customMessage = $this->scopeConfig->getValue('bell_icon/notifications/coupon_notification_message', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (empty($customMessage)) {
            $customMessage = 'Use coupon code to get a special discount: '; // Default message if no custom message is set
        }
        
        $customerIds = $this->getRequest()->getParam('selected', []);
        $couponIds = $this->getRequest()->getParam('coupon_id', []);

        $customersData = [];
        $customersUpdated = 0;

        if (empty($customerIds)) {
            // If all customers are selected
            $customerCollection = $this->customerCollectionFactory->create();
            foreach ($customerCollection as $customer) {
                $customersData[] = [
                    'id' => $customer->getId(),
                    'email' => $customer->getEmail()
                ];
                $customerIds[] = $customer->getId(); // Include all customer IDs
                $customersUpdated++;
            }
        } else {
            // If multi customers are selected
            foreach ($customerIds as $customerId) {
                try {
                    $customer = $this->customerRepository->getById((int)$customerId);
                    $customersData[] = [
                        'id' => $customer->getId(),
                        'email' => $customer->getEmail()
                    ];
                } catch (\Exception $e) {
                }
                $customersUpdated++;
            }
        }

        $couponCollection = $this->couponCollectionFactory->create()
        ->addFieldToFilter('coupon_id', ['in' => $couponIds]);
        $customerFromDate = date('Y-m-d H:i:s');
        $customerToDate = (new \DateTime($customerFromDate))->modify('+1 day')->format('Y-m-d H:i:s');
        
        foreach ($couponCollection as $coupon) {
            foreach ($customerIds as $customerId) {
                $sendNotification = $this->notificationSendFactory->create();
                $sendNotification->setData([
                    'customer_id' => $customerId,
                    'message' =>  __($customMessage . ' %1', $coupon->getCode()),
                    'from_date' =>  $customerFromDate,
                    'to_date' =>  $customerToDate
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
