<?php

class ThemeHouse_NoForo_Listener_InitDependencies extends ThemeHouse_Listener_InitDependencies
{
    public function run()
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noForum) {
            unset(XenForo_CacheRebuilder_Abstract::$builders['Forum']);
            unset(XenForo_CacheRebuilder_Abstract::$builders['Poll']);
            unset(XenForo_CacheRebuilder_Abstract::$builders['Thread']);
            XenForo_CacheRebuilder_Abstract::$builders['DailyStats'] =
                'ThemeHouse_NoForo_CacheRebuilder_DailyStats';
        }
                
        parent::run();
    } /* END run */

    public static function initDependencies(XenForo_Dependencies_Abstract $dependencies, array $data)
    {
        $initDependencies = new ThemeHouse_NoForo_Listener_InitDependencies($dependencies, $data);
        $initDependencies->run();
    } /* END initDependencies */
}