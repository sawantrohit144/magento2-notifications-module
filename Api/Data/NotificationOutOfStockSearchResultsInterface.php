<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Api\Data;

interface NotificationOutOfStockSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get NotificationOutOfStock list.
     * @return \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface[]
     */
    public function getItems();

    /**
     * Set customer_id list.
     * @param \Coditron\Notifications\Api\Data\NotificationOutOfStockInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

