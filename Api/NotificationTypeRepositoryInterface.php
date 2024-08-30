<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface NotificationTypeRepositoryInterface
{

    /**
     * Save NotificationType
     * @param \Coditron\Notifications\Api\Data\NotificationTypeInterface $notificationType
     * @return \Coditron\Notifications\Api\Data\NotificationTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Coditron\Notifications\Api\Data\NotificationTypeInterface $notificationType
    );

    /**
     * Retrieve NotificationType
     * @param string $notificationtypeId
     * @return \Coditron\Notifications\Api\Data\NotificationTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($notificationtypeId);

    /**
     * Retrieve NotificationType matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Coditron\Notifications\Api\Data\NotificationTypeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete NotificationType
     * @param \Coditron\Notifications\Api\Data\NotificationTypeInterface $notificationType
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Coditron\Notifications\Api\Data\NotificationTypeInterface $notificationType
    );

    /**
     * Delete NotificationType by ID
     * @param string $notificationtypeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($notificationtypeId);
}

