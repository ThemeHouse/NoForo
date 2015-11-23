<?php

class ThemeHouse_NoForo_Listener_ContainerPublicParams
{
    public static function containerPublicParams(array &$params, XenForo_Dependencies_Abstract $dependencies)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noForum) {
        	unset($params['tabs']['forums']);
        	if (!$params['homeTab']) {
            	$params['showHomeLink'] = true;
        	}
        }
    } /* END containerPublicParams */
}