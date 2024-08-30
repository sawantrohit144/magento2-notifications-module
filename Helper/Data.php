<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Coditron\Notifications\Model\NotificationOutOfStockFactory;
use Magento\Customer\Model\Session;

class Data extends AbstractHelper
{
    const XML_PATH_BELL_ICON = 'bell_icon/general/enable';
    const XML_PATH_ICON = 'bell_icon/general/icon';

    protected $_storeManager;
    protected $_assetRepository;
    protected $notificationOutOfStockFactory;
    protected $customerSession;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        NotificationOutOfStockFactory $notificationOutOfStockFactory,
        Session $customerSession,
        AssetRepository $assetRepository
    ) {
        $this->_storeManager = $storeManager;
        $this->_assetRepository = $assetRepository;
        $this->notificationOutOfStockFactory = $notificationOutOfStockFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function isBellIconEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_BELL_ICON, ScopeInterface::SCOPE_STORE);
    }

    public function getBellIconUrl()
    {
        $iconPath = $this->scopeConfig->getValue(self::XML_PATH_ICON, ScopeInterface::SCOPE_STORE);
        if ($iconPath) {
            // Remove 'default/' from the path if it exists
            $iconPath = str_replace('default/', '', $iconPath);
            $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            return $mediaUrl . 'bell_icon/' . $iconPath;
        } else {
            // Return default icon URL if no custom icon is set
            return $this->_assetRepository->getUrl('Coditron_Notifications::images/bell.png');
        }
        return null;
    }

    public function isProductAlreadySubscribed($productId)
    {
        $customerId = $this->customerSession->getCustomerId();
        $notification = $this->notificationOutOfStockFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('product_id', $productId)
            ->getFirstItem();

        return $notification->getId() ? true : false;
    }
}
