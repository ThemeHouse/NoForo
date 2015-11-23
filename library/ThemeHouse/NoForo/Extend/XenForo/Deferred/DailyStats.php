<?php

/**
 *
 * @see XenForo_Deferred_DailyStats
 */
class ThemeHouse_NoForo_Extend_XenForo_Deferred_DailyStats extends XFCP_ThemeHouse_NoForo_Extend_XenForo_Deferred_DailyStats
{

    /**
     *
     * @see XenForo_Deferred_DailyStats::execute()
     */
    public function execute(array $deferred, array $data, $targetRunTime, &$status)
    {
        $data = array_merge(array(
            'position' => 0
        ), $data);

        /* @var $statsModel XenForo_Model_Stats */
        $statsModel = XenForo_Model::create('XenForo_Model_Stats');

        if ($xenOptions->th_noForo_noForum) {
            if ($data['position'] == 0) {
                // delete old stats cache if required
                if (!empty($data['delete'])) {
                    $statsModel->deleteStats();
                }

                // an appropriate date from which to start... first thread, or earliest user reg?
                $data['position'] = XenForo_Model::create('XenForo_Model_User')->getEarliestRegistrationDate();

                // start on a 24 hour increment point
                $data['position'] = $data['position'] - $data['position'] % 86400;
            }
        }

        return parent::execute($deferred, $data, $targetRunTime, $status);
    } /* END execute */
}