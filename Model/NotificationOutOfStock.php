<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationOutOfStockInterface;
use Magento\Framework\Model\AbstractModel;

class NotificationOutOfStock extends AbstractModel implements NotificationOutOfStockInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Coditron\Notifications\Model\ResourceModel\NotificationOutOfStock::class);
    }

    /**
     * @inheritDoc
     */
    public function getNotificationoutofstockId()
    {
        return $this->getData(self::NOTIFICATIONOUTOFSTOCK_ID);
    }

    /**
     * @inheritDoc
     */
    public function setNotificationoutofstockId($notificationoutofstockId)
    {
        return $this->setData(self::NOTIFICATIONOUTOFSTOCK_ID, $notificationoutofstockId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }
}

