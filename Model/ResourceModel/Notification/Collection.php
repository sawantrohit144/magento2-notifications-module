<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'notification_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Coditron\Notifications\Model\Notification::class,
            \Coditron\Notifications\Model\ResourceModel\Notification::class
        );
    }
}

