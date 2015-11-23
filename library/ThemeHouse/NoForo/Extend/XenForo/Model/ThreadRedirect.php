<?php

/**
 *
 * @see XenForo_Model_ThreadRedirect
 */
class ThemeHouse_NoForo_Extend_XenForo_Model_ThreadRedirect extends XFCP_ThemeHouse_NoForo_Extend_XenForo_Model_ThreadRedirect
{

    /**
     *
     * @see XenForo_Model_ThreadRedirect::getExpiredThreadRedirects()
     */
    public function getExpiredThreadRedirects($expiredDate)
    {
        return array();
    } /* END getExpiredThreadRedirects */
}