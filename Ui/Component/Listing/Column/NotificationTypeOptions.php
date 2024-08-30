<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Coditron\Notifications\Model\ResourceModel\NotificationType\CollectionFactory;

class NotificationTypeOptions implements OptionSourceInterface
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $options = [];
        $collection = $this->collectionFactory->create();
        foreach ($collection as $item) {
            $options[] = [
                'value' => $item->getName(),
                'label' => $item->getName(),
            ];
        }
        return $options;
    }
}
