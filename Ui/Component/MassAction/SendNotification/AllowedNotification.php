<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Ui\Component\MassAction\SendNotification;

use Magento\Framework\UrlInterface;
use JsonSerializable;
use Magento\SalesRule\Model\ResourceModel\Coupon\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class AllowedNotification
 */
class AllowedNotification implements JsonSerializable
{
    /**
     * @var array
     */
    protected $_options;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * Additional options params
     *
     * @var array
     */
    protected $_data;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Base URL for subactions
     *
     * @var string
     */
    protected $_urlPath;

    /**
     * Param name for subactions
     *
     * @var string
     */
    protected $_paramName;

    /**
     * Additional params for subactions
     *
     * @var array
     */
    protected $_additionalData = [];

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        UrlInterface $urlBuilder,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->_data = $data;
    }

    /**
     * Get action options
     *
     * @return array
     */
    public function jsonSerialize(): array
    {

        $isEnabled = $this->scopeConfig->getValue('bell_icon/notifications/notify_on_coupon', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (!$isEnabled) {
            return [
                [
                    'value' => 'no_notification',
                    'label' => __('No notifications')
                ]
            ];
        }
        
        $customMessage = $this->scopeConfig->getValue('bell_icon/notifications/coupon_notification_message', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (empty($customMessage)) {
            // Default message if no custom message is set
            $customMessage = 'Use coupon code to get a special discount: '; 
        }

        if ($this->_options === null) {
            $notificationsColl = $this->_collectionFactory->create();

            if (!$notificationsColl->getSize()) {
                // Handle empty collection
                return [
                    [
                        'value' => 'no_notification',
                        'label' => __('No notifications')
                    ]
                ];
            }

            $options = [];
            $currentDateTime = date('Y-m-d H:i:s'); 
            foreach ($notificationsColl as $notification) {
                $fromDateValue = $notification->getData('from_date');
                $toDateValue = $notification->getData('to_date');
                if ($fromDateValue <= $currentDateTime && $toDateValue >= $currentDateTime) {
                    $options[] = [
                        'value' => $notification->getCouponId(),
                        'label' => __($customMessage . ' %1', $notification->getCode()) 
                    ];
                }
            }

            $this->prepareData();
            $this->_options = [];

            foreach ($options as $optionCode) {
                $optionData = [
                    'type' => 'coupon_' . $optionCode['value'],
                    'label' => $optionCode['label']
                ];
                if ($this->_urlPath && $this->_paramName) {
                    $optionData['url'] = $this->_urlBuilder->getUrl(
                        $this->_urlPath,
                        [$this->_paramName => $optionCode['value']]
                    );
                }

                $this->_options[$optionCode['value']] = array_merge_recursive(
                    $optionData,
                    $this->_additionalData
                );
            }

            $this->_options = array_values($this->_options);
        }

        return $this->_options;
    }

    /**
     * Prepare additional data for subactions
     *
     * @return void
     */
    protected function prepareData(): void
    {
        // Set URL path and parameter name
        $this->_urlPath = 'coditron_notifications/index/allowednotification';
        $this->_paramName = 'coupon_id';

        foreach ($this->_data as $key => $value) {
            if ($key !== 'urlPath' && $key !== 'paramName') {
                $this->_additionalData[$key] = $value;
            }
        }
    }
}