<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationSendInterface
{

    const MESSAGE = 'message';
    const NOTIFICATION_ID = 'notification_id';
    const STATUS = 'status';
    const CUSTOMER_ID = 'customer_id';
    const NOTIFICATIONSEND_ID = 'notificationsend_id';

    /**
     * Get notificationsend_id
     * @return string|null
     */
    public function getNotificationsendId();

    /**
     * Set notificationsend_id
     * @param string $notificationsendId
     * @return \Coditron\Notifications\NotificationSend\Api\Data\NotificationSendInterface
     */
    public function setNotificationsendId($notificationsendId);

    /**
     * Get notification_id
     * @return string|null
     */
    public function getNotificationId();

    /**
     * Set notification_id
     * @param string $notificationId
     * @return \Coditron\Notifications\NotificationSend\Api\Data\NotificationSendInterface
     */
    public function setNotificationId($notificationId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Coditron\Notifications\NotificationSend\Api\Data\NotificationSendInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get message
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     * @param string $message
     * @return \Coditron\Notifications\NotificationSend\Api\Data\NotificationSendInterface
     */
    public function setMessage($message);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Coditron\Notifications\NotificationSend\Api\Data\NotificationSendInterface
     */
    public function setStatus($status);
}

