<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationTypeInterface
{

    const NAME = 'name';
    const NOTIFICATIONTYPE_ID = 'notificationtype_id';
    const CREATED_AT = 'created_at';

    /**
     * Get notificationtype_id
     * @return string|null
     */
    public function getNotificationtypeId();

    /**
     * Set notificationtype_id
     * @param string $notificationtypeId
     * @return \Coditron\Notifications\NotificationType\Api\Data\NotificationTypeInterface
     */
    public function setNotificationtypeId($notificationtypeId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Coditron\Notifications\NotificationType\Api\Data\NotificationTypeInterface
     */
    public function setName($name);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Coditron\Notifications\NotificationType\Api\Data\NotificationTypeInterface
     */
    public function setCreatedAt($createdAt);
}

