<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationTypeInterface;
use Magento\Framework\Model\AbstractModel;

class NotificationType extends AbstractModel implements NotificationTypeInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Coditron\Notifications\Model\ResourceModel\NotificationType::class);
    }
    /**
     * Before save method to set created_at
     *
     * @return AbstractModel
     */
    public function beforeSave()
    {
        if ($this->isObjectNew() && !$this->hasData('created_at')) {
            $this->setData('created_at', date('Y-m-d H:i:s'));
        }

        return parent::beforeSave();
    }

    /**
     * @inheritDoc
     */
    public function getNotificationtypeId()
    {
        return $this->getData(self::NOTIFICATIONTYPE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setNotificationtypeId($notificationtypeId)
    {
        return $this->setData(self::NOTIFICATIONTYPE_ID, $notificationtypeId);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}

