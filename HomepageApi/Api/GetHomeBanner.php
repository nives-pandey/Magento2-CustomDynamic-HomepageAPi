<?php

namespace Dynamic\HomepageApi\Api;

interface GetHomeBanner {

	/**
     * Returns banner data
     *
     * @api
     * @return return banner array collection.
     */
    public function getBannerList();
}
