<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationSendInterface;
use Magento\Framework\Model\AbstractModel;

class NotificationSend extends AbstractModel implements NotificationSendInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Coditron\Notifications\Model\ResourceModel\NotificationSend::class);
    }

    /**
     * @inheritDoc
     */
    public function getNotificationsendId()
    {
        return $this->getData(self::NOTIFICATIONSEND_ID);
    }

    /**
     * @inheritDoc
     */
    public function setNotificationsendId($notificationsendId)
    {
        return $this->setData(self::NOTIFICATIONSEND_ID, $notificationsendId);
    }

    /**
     * @inheritDoc
     */
    public function getNotificationId()
    {
        return $this->getData(self::NOTIFICATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setNotificationId($notificationId)
    {
        return $this->setData(self::NOTIFICATION_ID, $notificationId);
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
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritDoc
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}

