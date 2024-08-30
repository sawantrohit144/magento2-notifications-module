<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationTypeInterface;
use Coditron\Notifications\Api\Data\NotificationTypeInterfaceFactory;
use Coditron\Notifications\Api\Data\NotificationTypeSearchResultsInterfaceFactory;
use Coditron\Notifications\Api\NotificationTypeRepositoryInterface;
use Coditron\Notifications\Model\ResourceModel\NotificationType as ResourceNotificationType;
use Coditron\Notifications\Model\ResourceModel\NotificationType\CollectionFactory as NotificationTypeCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class NotificationTypeRepository implements NotificationTypeRepositoryInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var NotificationTypeInterfaceFactory
     */
    protected $notificationTypeFactory;

    /**
     * @var ResourceNotificationType
     */
    protected $resource;

    /**
     * @var NotificationType
     */
    protected $searchResultsFactory;

    /**
     * @var NotificationTypeCollectionFactory
     */
    protected $notificationTypeCollectionFactory;


    /**
     * @param ResourceNotificationType $resource
     * @param NotificationTypeInterfaceFactory $notificationTypeFactory
     * @param NotificationTypeCollectionFactory $notificationTypeCollectionFactory
     * @param NotificationTypeSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceNotificationType $resource,
        NotificationTypeInterfaceFactory $notificationTypeFactory,
        NotificationTypeCollectionFactory $notificationTypeCollectionFactory,
        NotificationTypeSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->notificationTypeFactory = $notificationTypeFactory;
        $this->notificationTypeCollectionFactory = $notificationTypeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        NotificationTypeInterface $notificationType
    ) {
        try {
            $this->resource->save($notificationType);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notificationType: %1',
                $exception->getMessage()
            ));
        }
        return $notificationType;
    }

    /**
     * @inheritDoc
     */
    public function get($notificationTypeId)
    {
        $notificationType = $this->notificationTypeFactory->create();
        $this->resource->load($notificationType, $notificationTypeId);
        if (!$notificationType->getId()) {
            throw new NoSuchEntityException(__('NotificationType with id "%1" does not exist.', $notificationTypeId));
        }
        return $notificationType;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->notificationTypeCollectionFactory->create();
        
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
        NotificationTypeInterface $notificationType
    ) {
        try {
            $notificationTypeModel = $this->notificationTypeFactory->create();
            $this->resource->load($notificationTypeModel, $notificationType->getNotificationtypeId());
            $this->resource->delete($notificationTypeModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the NotificationType: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($notificationTypeId)
    {
        return $this->delete($this->get($notificationTypeId));
    }
}

