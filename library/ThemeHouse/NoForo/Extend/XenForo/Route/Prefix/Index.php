<?php

/**
 *
 * @see XenForo_Route_Prefix_Index
 */
class ThemeHouse_NoForo_Extend_XenForo_Route_Prefix_Index extends XFCP_ThemeHouse_NoForo_Extend_XenForo_Route_Prefix_Index
{

    /**
     *
     * @see XenForo_Route_Prefix_Index::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noForum) {
            return $router->getRouteMatch('XenForo_ControllerPublic_Index', 'index', 'home');
        }

        return parent::match($routePath, $request, $router);
    } /* END match */
}