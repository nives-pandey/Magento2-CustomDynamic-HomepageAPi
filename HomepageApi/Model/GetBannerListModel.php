<?php

namespace Dynamic\HomepageApi\Model;

use Dynamic\HomepageApi\Api\GetHomeBanner;

class GetBannerListModel implements GetHomeBanner
{
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \WeltPixel\OwlCarouselSlider\Model\Banner
     */
    protected $banner;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Banner data constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \WeltPixel\OwlCarouselSlider\Model\Banner $banner
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \WeltPixel\OwlCarouselSlider\Model\Banner $banner,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->banner = $banner;
        $this->request = $request;
        $this->storeManager = $storeManager;
    }

    /**
     * Returns Banner data
     *
     * @api
     * @return return Banner array collection.
     */
    public function getBannerList()
    {
        $data = [];

        $sliderId = $this->request->getPostValue('slider_id');

        if(!isset($sliderId) && !$sliderId) {
            $data = array(
                ['status' => 'No Data','message' => __('Please enter the slider Id.') ]
            );
            return $data;
        }
        
        $bannerCollection = $this->banner->getCollection()->addFieldToFilter('slider_id', array('eq' => $sliderId))
                            ->addFieldToFilter('status', array('eq' => 1));
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        if(count($bannerCollection) > 0 && !empty($bannerCollection)) {
            foreach ($bannerCollection as $banner) {
                $data[] = [
                    "id" => $banner->getId(),
                    "slider_id" => $banner->getSliderId(),
                    "status" => $banner->getStatus(),
                    "show_title" => $banner->getShowTitle(),
                    "title" => $banner->getTitle(),
                    "description" => $banner->getDescription(),
                    "alt_text" => $banner->getAltText(),
                    "url" => $banner->getUrl(),
                    "custom_content" => $banner->getCustomContent(),
                    "image" => ($banner->getImage()) ? $mediaUrl.$banner->getImage() : '',
                    "mobile_image" => ($banner->getMobileImage()) ? $mediaUrl.$banner->getMobileImage() : '',
                    "thumb_image" => ($banner->getThumbImage()) ? $mediaUrl.$banner->getThumbImage() : '',
                    "video" => $banner->getVideo(),
                    "valid_from" => $banner->getValidFrom(),
                    "valid_to" => $banner->getValidTo(),
                    "ga_promo_id" => $banner->getGaPromoId(),
                    "ga_promo_name" => $banner->getGaPromoName(),
                    "ga_promo_creative" => $banner->getGaPromoCreative(),
                    "ga_promo_position" => $banner->getGaPromoPosition(),
                ];
            }
        } else {
            $data = array(
                ['status' => 'No Data','message' => __('There are no banner data in this website.') ]
            );
        }
        
        return $data;
    }
}
