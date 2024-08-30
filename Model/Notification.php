<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationInterface;
use Magento\Framework\Model\AbstractModel;

class Notification extends AbstractModel implements NotificationInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Coditron\Notifications\Model\ResourceModel\Notification::class);
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
    public function getNotificationName()
    {
        return $this->getData(self::NOTIFICATION_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setNotificationName($notificationName)
    {
        return $this->setData(self::NOTIFICATION_NAME, $notificationName);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getNotificationType()
    {
        return $this->getData(self::NOTIFICATION_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setNotificationType($notificationType)
    {
        return $this->setData(self::NOTIFICATION_TYPE, $notificationType);
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

    /**
     * @inheritDoc
     */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setFromDate($fromDate)
    {
        return $this->setData(self::FROM_DATE, $fromDate);
    }

    /**
     * @inheritDoc
     */
    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setToDate($toDate)
    {
        return $this->setData(self::TO_DATE, $toDate);
    }
}
