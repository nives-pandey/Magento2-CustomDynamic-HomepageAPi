<?php

namespace Dynamic\HomepageApi\Model;

use Dynamic\HomepageApi\Api\GetImage;
use Magento\Store\Model\ScopeInterface;

class GetImageListModel implements GetImage
{
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Image data constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Returns Image data
     *
     * @api
     * @return return Image array collection.
     */
    public function getImageList()
    {
        $data = [];

        $data[] = [
            "title1" => $this->getConfigValue('homepageapi/config/title1'),
            "image_url1" => $this->getConfigValue('homepageapi/config/image_url1'),
            "title2" => $this->getConfigValue('homepageapi/config/title2'),
            "image_url2" => $this->getConfigValue('homepageapi/config/image_url2'),
        ];
                
        return $data;
    }

    /**
    * Returns config data
    *
    * @api
    * @param  string $field.
    * @param  string $storeId.
    * @return string config value.
    */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
}
