<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationOutOfStockInterface
{

    const PRODUCT_NAME = 'product_name';
    const PRODUCT_ID = 'product_id';
    const CUSTOMER_ID = 'customer_id';
    const NOTIFICATIONOUTOFSTOCK_ID = 'notificationoutofstock_id';

    /**
     * Get notificationoutofstock_id
     * @return string|null
     */
    public function getNotificationoutofstockId();

    /**
     * Set notificationoutofstock_id
     * @param string $notificationoutofstockId
     * @return \Coditron\Notifications\NotificationOutOfStock\Api\Data\NotificationOutOfStockInterface
     */
    public function setNotificationoutofstockId($notificationoutofstockId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Coditron\Notifications\NotificationOutOfStock\Api\Data\NotificationOutOfStockInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get product_id
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     * @param string $productId
     * @return \Coditron\Notifications\NotificationOutOfStock\Api\Data\NotificationOutOfStockInterface
     */
    public function setProductId($productId);

    /**
     * Get product_name
     * @return string|null
     */
    public function getProductName();

    /**
     * Set product_name
     * @param string $productName
     * @return \Coditron\Notifications\NotificationOutOfStock\Api\Data\NotificationOutOfStockInterface
     */
    public function setProductName($productName);
}

