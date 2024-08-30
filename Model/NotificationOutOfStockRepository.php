<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationOutOfStockInterface;
use Coditron\Notifications\Api\Data\NotificationOutOfStockInterfaceFactory;
use Coditron\Notifications\Api\Data\NotificationOutOfStockSearchResultsInterfaceFactory;
use Coditron\Notifications\Api\NotificationOutOfStockRepositoryInterface;
use Coditron\Notifications\Model\ResourceModel\NotificationOutOfStock as ResourceNotificationOutOfStock;
use Coditron\Notifications\Model\ResourceModel\NotificationOutOfStock\CollectionFactory as NotificationOutOfStockCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class NotificationOutOfStockRepository implements NotificationOutOfStockRepositoryInterface
{

    /**
     * @var NotificationOutOfStockCollectionFactory
     */
    protected $notificationOutOfStockCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceNotificationOutOfStock
     */
    protected $resource;

    /**
     * @var NotificationOutOfStockInterfaceFactory
     */
    protected $notificationOutOfStockFactory;

    /**
     * @var NotificationOutOfStock
     */
    protected $searchResultsFactory;


    /**
     * @param ResourceNotificationOutOfStock $resource
     * @param NotificationOutOfStockInterfaceFactory $notificationOutOfStockFactory
     * @param NotificationOutOfStockCollectionFactory $notificationOutOfStockCollectionFactory
     * @param NotificationOutOfStockSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceNotificationOutOfStock $resource,
        NotificationOutOfStockInterfaceFactory $notificationOutOfStockFactory,
        NotificationOutOfStockCollectionFactory $notificationOutOfStockCollectionFactory,
        NotificationOutOfStockSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->notificationOutOfStockFactory = $notificationOutOfStockFactory;
        $this->notificationOutOfStockCollectionFactory = $notificationOutOfStockCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        NotificationOutOfStockInterface $notificationOutOfStock
    ) {
        try {
            $this->resource->save($notificationOutOfStock);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notificationOutOfStock: %1',
                $exception->getMessage()
            ));
        }
        return $notificationOutOfStock;
    }

    /**
     * @inheritDoc
     */
    public function get($notificationOutOfStockId)
    {
        $notificationOutOfStock = $this->notificationOutOfStockFactory->create();
        $this->resource->load($notificationOutOfStock, $notificationOutOfStockId);
        if (!$notificationOutOfStock->getId()) {
            throw new NoSuchEntityException(__('NotificationOutOfStock with id "%1" does not exist.', $notificationOutOfStockId));
        }
        return $notificationOutOfStock;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->notificationOutOfStockCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(
        NotificationOutOfStockInterface $notificationOutOfStock
    ) {
        try {
            $notificationOutOfStockModel = $this->notificationOutOfStockFactory->create();
            $this->resource->load($notificationOutOfStockModel, $notificationOutOfStock->getNotificationoutofstockId());
            $this->resource->delete($notificationOutOfStockModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the NotificationOutOfStock: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($notificationOutOfStockId)
    {
        return $this->delete($this->get($notificationOutOfStockId));
    }
}

