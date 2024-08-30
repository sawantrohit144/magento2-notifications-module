<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationInterface;
use Coditron\Notifications\Api\Data\NotificationInterfaceFactory;
use Coditron\Notifications\Api\Data\NotificationSearchResultsInterfaceFactory;
use Coditron\Notifications\Api\NotificationRepositoryInterface;
use Coditron\Notifications\Model\ResourceModel\Notification as ResourceNotification;
use Coditron\Notifications\Model\ResourceModel\Notification\CollectionFactory as NotificationCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class NotificationRepository implements NotificationRepositoryInterface
{

    /**
     * @var ResourceNotification
     */
    protected $resource;

    /**
     * @var NotificationCollectionFactory
     */
    protected $notificationCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var NotificationInterfaceFactory
     */
    protected $notificationFactory;

    /**
     * @var Notification
     */
    protected $searchResultsFactory;


    /**
     * @param ResourceNotification $resource
     * @param NotificationInterfaceFactory $notificationFactory
     * @param NotificationCollectionFactory $notificationCollectionFactory
     * @param NotificationSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceNotification $resource,
        NotificationInterfaceFactory $notificationFactory,
        NotificationCollectionFactory $notificationCollectionFactory,
        NotificationSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->notificationFactory = $notificationFactory;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(NotificationInterface $notification)
    {
        try {
            $this->resource->save($notification);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notification: %1',
                $exception->getMessage()
            ));
        }
        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function get($notificationId)
    {
        $notification = $this->notificationFactory->create();
        $this->resource->load($notification, $notificationId);
        if (!$notification->getId()) {
            throw new NoSuchEntityException(__('Notification with id "%1" does not exist.', $notificationId));
        }
        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->notificationCollectionFactory->create();
        
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
    public function delete(NotificationInterface $notification)
    {
        try {
            $notificationModel = $this->notificationFactory->create();
            $this->resource->load($notificationModel, $notification->getNotificationId());
            $this->resource->delete($notificationModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Notification: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($notificationId)
    {
        return $this->delete($this->get($notificationId));
    }
}

