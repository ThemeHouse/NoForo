<?php

/**
 * Cron entry for updating view counts.
 */
class ThemeHouse_NoForo_CronEntry_Views extends XenForo_CronEntry_Views
{

    /**
     * Updates view counters for various content types.
     */
    public static function runViewUpdate()
    {
        XenForo_Model::create('XenForo_Model_Attachment')->updateAttachmentViews();
    } /* END runViewUpdate */
}