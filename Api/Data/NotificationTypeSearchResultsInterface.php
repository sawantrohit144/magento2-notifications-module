<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationTypeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get NotificationType list.
     * @return \Coditron\Notifications\Api\Data\NotificationTypeInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Coditron\Notifications\Api\Data\NotificationTypeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

