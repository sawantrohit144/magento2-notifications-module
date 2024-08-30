<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Notification list.
     * @return \Coditron\Notifications\Api\Data\NotificationInterface[]
     */
    public function getItems();

    /**
     * Set notification_name list.
     * @param \Coditron\Notifications\Api\Data\NotificationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

