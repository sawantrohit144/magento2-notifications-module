<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface NotificationRepositoryInterface
{

    /**
     * Save Notification
     * @param \Coditron\Notifications\Api\Data\NotificationInterface $notification
     * @return \Coditron\Notifications\Api\Data\NotificationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Coditron\Notifications\Api\Data\NotificationInterface $notification
    );

    /**
     * Retrieve Notification
     * @param string $notificationId
     * @return \Coditron\Notifications\Api\Data\NotificationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($notificationId);

    /**
     * Retrieve Notification matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Coditron\Notifications\Api\Data\NotificationSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Notification
     * @param \Coditron\Notifications\Api\Data\NotificationInterface $notification
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Coditron\Notifications\Api\Data\NotificationInterface $notification
    );

    /**
     * Delete Notification by ID
     * @param string $notificationId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($notificationId);
}

