<?php

class ThemeHouse_NoForo_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_NoForo' => array(
                'controller' => array(
                    'XenForo_ControllerAdmin_User',
                    'XenForo_ControllerPublic_Index',
                    'XenForo_ControllerPublic_Member'
                ), /* END 'controller' */
                'datawriter' => array(
                    'XenForo_DataWriter_User'
                ), /* END 'datawriter' */
                'deferred' => array(
                    'XenForo_Deferred_DailyStats'
                ), /* END 'deferred' */
                'model' => array(
                    'XenForo_Model_Cron',
                    'XenForo_Model_ThreadRedirect',
                    'XenForo_Model_User'
                ), /* END 'model' */
                'route_prefix' => array(
                    'XenForo_Route_Prefix_Index'
                ), /* END 'route_prefix' */
            ), /* END 'ThemeHouse_NoForo' */
        );
    } /* END _getExtendedClasses */

    public static function loadClassController($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_NoForo_Listener_LoadClass', $class, $extend, 'controller');
    } /* END loadClassController */

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_NoForo_Listener_LoadClass', $class, $extend, 'datawriter');
    } /* END loadClassDataWriter */

    public static function loadClassDeferred($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_NoForo_Listener_LoadClass', $class, $extend, 'deferred');
    } /* END loadClassDeferred */

    public static function loadClassModel($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_NoForo_Listener_LoadClass', $class, $extend, 'model');
    } /* END loadClassModel */

    public static function loadClassRoutePrefix($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_NoForo_Listener_LoadClass', $class, $extend, 'route_prefix');
    } /* END loadClassRoutePrefix */
}