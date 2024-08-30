<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface NotificationOutOfStockRepositoryInterface
{

    /**
     * Save NotificationOutOfStock
     * @param \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface $notificationOutOfStock
     * @return \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface $notificationOutOfStock
    );

    /**
     * Retrieve NotificationOutOfStock
     * @param string $notificationoutofstockId
     * @return \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($notificationoutofstockId);

    /**
     * Retrieve NotificationOutOfStock matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Coditron\Notifications\Api\Data\NotificationOutOfStockSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete NotificationOutOfStock
     * @param \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface $notificationOutOfStock
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface $notificationOutOfStock
    );

    /**
     * Delete NotificationOutOfStock by ID
     * @param string $notificationoutofstockId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($notificationoutofstockId);
}

