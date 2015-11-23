<?php

/**
 *
 * @see XenForo_Model_Cron
 */
class ThemeHouse_NoForo_Extend_XenForo_Model_Cron extends XFCP_ThemeHouse_NoForo_Extend_XenForo_Model_Cron
{

    /**
     *
     * @see XenForo_Model_Cron::runEntry()
     */
    public function runEntry(array $entry)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noForum && $entry['cron_class'] == 'XenForo_CronEntry_CleanUp') {
            $entry['cron_class'] = 'ThemeHouse_NoForo_CronEntry_CleanUp';
        }
        return parent::runEntry($entry);
    } /* END runEntry */
}