<?php

class ThemeHouse_NoForo_CronEntry_CleanUp extends XenForo_CronEntry_CleanUp
{

    /**
     * Clean up tasks that should be done hourly. This task cannot be relied on
     * to run every hour, consistently.
     */
    public static function runHourlyCleanUp()
    {
        // delete unassociated attachments
        $unassociatedAttachCutOff = XenForo_Application::$time - 86400;
        $attachmentModel = XenForo_Model::create('XenForo_Model_Attachment');
        $attachmentModel->deleteUnassociatedAttachments($unassociatedAttachCutOff);
        $attachmentModel->deleteUnusedAttachmentData();

        // delete expired sessions
        $class = XenForo_Application::resolveDynamicClass('XenForo_Session');
        $session = new $class();
        $session->deleteExpiredSessions();

        // delete expired admin sessions
        $session = new $class(array('admin' => true));
        $session->deleteExpiredSessions();

        // delete expired session activities
        $sessionModel = XenForo_Model::create('XenForo_Model_Session');
        $sessionCleanUpCutOff = XenForo_Application::$time - 3600;
        $sessionModel->updateUserLastActivityFromSessions();
        $sessionModel->deleteSessionActivityOlderThanCutOff($sessionCleanUpCutOff);

        XenForo_Model::create('XenForo_Model_Alert')->deleteOldReadAlerts();
        XenForo_Model::create('XenForo_Model_Alert')->deleteOldUnreadAlerts();

        XenForo_Model::create('XenForo_Model_NewsFeed')->deleteOldNewsFeedItems();

        XenForo_Model::create('XenForo_Model_Login')->cleanUpLoginAttempts();

        XenForo_Model::create('XenForo_Model_CaptchaQuestion')->deleteOldCaptchas();

        XenForo_Model::create('XenForo_Model_FloodCheck')->pruneFloodCheckData();

        XenForo_Model::create('XenForo_Model_BbCode')->trimBbCodeCache();

        if (XenForo_Application::$versionId > 1020000) {
            XenForo_Model::create('XenForo_Model_UserConfirmation')->cleanUpUserConfirmationRecords();

            XenForo_Model::create('XenForo_Model_SpamPrevention')->cleanUpRegistrationResultCache();
            XenForo_Model::create('XenForo_Model_SpamPrevention')->cleanupContentSpamCheck();
            XenForo_Model::create('XenForo_Model_SpamPrevention')->cleanupSpamTriggerLog();
        }

        if (XenForo_Application::$versionId > 1030000) {
            XenForo_Model::create('XenForo_Model_ImageProxy')->pruneImageCache();
            XenForo_Model::create('XenForo_Model_ImageProxy')->pruneImageProxyLogs();
            XenForo_Model::create('XenForo_Model_LinkProxy')->pruneLinkProxyLogs();
        }
    } /* END runHourlyCleanUp */

    /**
     * Clean up tasks that should be done daily.
     * This task cannot be relied on to run daily, consistently.
     */
    public static function runDailyCleanUp()
    {
        $db = XenForo_Application::get('db');

        // delete old searches
        $db->delete('xf_search', 'search_date < ' . (XenForo_Application::$time - 86400));

        XenForo_Model::create('XenForo_Model_Log')->pruneAdminLogEntries();
        XenForo_Model::create('XenForo_Model_Log')->pruneModeratorLogEntries();
        if (XenForo_Application::$versionId > 1020000) {
            XenForo_Model::create('XenForo_Model_UserChangeLog')->pruneChangeLog();
            XenForo_Model::create('XenForo_Model_EditHistory')->pruneEditHistory();
            XenForo_Model::create('XenForo_Model_Template')->pruneEditHistory();
            XenForo_Model::create('XenForo_Model_Draft')->pruneDrafts();
            XenForo_Model::create('XenForo_Model_Ip')->pruneIps();
        }
    } /* END runDailyCleanUp */
}