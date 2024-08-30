<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
namespace Coditron\Notifications\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Coditron\Notifications\Helper\Data as NotificationHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class OutOfStockButton extends Template
{
    protected $productRepository;
    protected $stockRegistry;
    protected $customerSession;
    protected $notificationHelper;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry,
        Session $customerSession,
        NotificationHelper $notificationHelper,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        $this->customerSession = $customerSession;
        $this->notificationHelper = $notificationHelper;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * Get the current product
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     */
    public function getProduct()
    {
        $productId = $this->getRequest()->getParam('id');

        if ($productId) {
            return $this->productRepository->getById($productId);
        }

        return null;
    }

    /**
     * Check if the current product is out of stock
     *
     * @return bool
     */
    public function isProductOutOfStock()
    {
        $product = $this->getProduct();

        if ($product) {
            $stockItem = $this->stockRegistry->getStockItem($product->getId());
            return !$stockItem->getIsInStock() || $stockItem->getQty() <= 0;
        }

        return false;
    }

    public function isCustLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function shouldShowButton($productId)
    {
        return !$this->notificationHelper->isProductAlreadySubscribed($productId);
    }

    public function isEnable(){
        $isEnabled = $this->scopeConfig->getValue('out_of_stock/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$isEnabled) {
            return false;
        }
        return true;
    }
    public function getButtonText()
    {
        $buttonText = $this->scopeConfig->getValue('out_of_stock/general/button_text',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    
        if (empty($buttonText)) {
            $buttonText = __('Notify Me When Available');
        }
        return $buttonText;
    }
    
}
