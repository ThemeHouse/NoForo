<?php

class ThemeHouse_NoForo_Option_NoMessageCount
{
    public static function validateNoMessageCount(&$option, XenForo_DataWriter $dw, $fieldName)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_sandbox) {
            return true;
        }

        $db = XenForo_Application::get('db');

        $keys = array_keys($db->describeTable('xf_user'));
        if ($option) {
            if (in_array('message_count', $keys)) {
                $db->query('ALTER TABLE xf_user DROP message_count');
            }
        } else {
            if (!in_array('message_count', $keys)) {
                $db->query('ALTER TABLE xf_user ADD message_count INT UNSIGNED NOT NULL DEFAULT 0');
            }
        }
        return true;
    } /* END validateNoMessageCount */
}