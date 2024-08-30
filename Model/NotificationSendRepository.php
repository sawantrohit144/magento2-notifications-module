<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\Notifications\Model;

use Coditron\Notifications\Api\Data\NotificationSendInterface;
use Coditron\Notifications\Api\Data\NotificationSendInterfaceFactory;
use Coditron\Notifications\Api\Data\NotificationSendSearchResultsInterfaceFactory;
use Coditron\Notifications\Api\NotificationSendRepositoryInterface;
use Coditron\Notifications\Model\ResourceModel\NotificationSend as ResourceNotificationSend;
use Coditron\Notifications\Model\ResourceModel\NotificationSend\CollectionFactory as NotificationSendCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class NotificationSendRepository implements NotificationSendRepositoryInterface
{

    /**
     * @var NotificationSend
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var NotificationSendInterfaceFactory
     */
    protected $notificationSendFactory;

    /**
     * @var NotificationSendCollectionFactory
     */
    protected $notificationSendCollectionFactory;

    /**
     * @var ResourceNotificationSend
     */
    protected $resource;


    /**
     * @param ResourceNotificationSend $resource
     * @param NotificationSendInterfaceFactory $notificationSendFactory
     * @param NotificationSendCollectionFactory $notificationSendCollectionFactory
     * @param NotificationSendSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceNotificationSend $resource,
        NotificationSendInterfaceFactory $notificationSendFactory,
        NotificationSendCollectionFactory $notificationSendCollectionFactory,
        NotificationSendSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->notificationSendFactory = $notificationSendFactory;
        $this->notificationSendCollectionFactory = $notificationSendCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        NotificationSendInterface $notificationSend
    ) {
        try {
            $this->resource->save($notificationSend);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notificationSend: %1',
                $exception->getMessage()
            ));
        }
        return $notificationSend;
    }

    /**
     * @inheritDoc
     */
    public function get($notificationSendId)
    {
        $notificationSend = $this->notificationSendFactory->create();
        $this->resource->load($notificationSend, $notificationSendId);
        if (!$notificationSend->getId()) {
            throw new NoSuchEntityException(__('NotificationSend with id "%1" does not exist.', $notificationSendId));
        }
        return $notificationSend;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->notificationSendCollectionFactory->create();
        
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
        NotificationSendInterface $notificationSend
    ) {
        try {
            $notificationSendModel = $this->notificationSendFactory->create();
            $this->resource->load($notificationSendModel, $notificationSend->getNotificationsendId());
            $this->resource->delete($notificationSendModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the NotificationSend: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($notificationSendId)
    {
        return $this->delete($this->get($notificationSendId));
    }
}

