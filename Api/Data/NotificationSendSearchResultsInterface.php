<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationSendSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get NotificationSend list.
     * @return \Coditron\Notifications\Api\Data\NotificationSendInterface[]
     */
    public function getItems();

    /**
     * Set notification_id list.
     * @param \Coditron\Notifications\Api\Data\NotificationSendInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

