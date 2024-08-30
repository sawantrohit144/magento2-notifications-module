<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface NotificationSendRepositoryInterface
{

    /**
     * Save NotificationSend
     * @param \Coditron\Notifications\Api\Data\NotificationSendInterface $notificationSend
     * @return \Coditron\Notifications\Api\Data\NotificationSendInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Coditron\Notifications\Api\Data\NotificationSendInterface $notificationSend
    );

    /**
     * Retrieve NotificationSend
     * @param string $notificationsendId
     * @return \Coditron\Notifications\Api\Data\NotificationSendInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($notificationsendId);

    /**
     * Retrieve NotificationSend matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Coditron\Notifications\Api\Data\NotificationSendSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete NotificationSend
     * @param \Coditron\Notifications\Api\Data\NotificationSendInterface $notificationSend
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Coditron\Notifications\Api\Data\NotificationSendInterface $notificationSend
    );

    /**
     * Delete NotificationSend by ID
     * @param string $notificationsendId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($notificationsendId);
}

