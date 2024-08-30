<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationInterface
{
    const NOTIFICATION_NAME = 'notification_name';
    const NOTIFICATION_ID = 'notification_id';
    const DESCRIPTION = 'description';
    const NOTIFICATION_TYPE = 'notification_type';
    const FROM_DATE = 'from_date'; 
    const TO_DATE = 'to_date'; 
    const STATUS = 'status';

    /**
     * Get notification_id
     * @return string|null
     */
    public function getNotificationId();

    /**
     * Set notification_id
     * @param string $notificationId
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setNotificationId($notificationId);

    /**
     * Get notification_name
     * @return string|null
     */
    public function getNotificationName();

    /**
     * Set notification_name
     * @param string $notificationName
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setNotificationName($notificationName);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setDescription($description);

    /**
     * Get notification_type
     * @return string|null
     */
    public function getNotificationType();

    /**
     * Set notification_type
     * @param string $notificationType
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setNotificationType($notificationType);

    
    /**
     * Get from_date
     * @return string|null
     */
    public function getFromDate();
    
    /**
     * Set from_date
     * @param string $fromDate
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setFromDate($fromDate);
    
    /**
     * Get to_date
     * @return string|null
     */
    public function getToDate();

    /**
     * Set to_date
     * @param string $toDate
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setToDate($toDate);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();
    
    /**
     * Set status
     * @param string $status
     * @return \Coditron\Notifications\Notification\Api\Data\NotificationInterface
     */
    public function setStatus($status);
}
