<?php

/**
 * Cache rebuilder for daily stats.
 */
class ThemeHouse_NoForo_CacheRebuilder_DailyStats extends XenForo_CacheRebuilder_DailyStats
{
	/**
	 * @see XenForo_CacheRebuilder_DailyStats::rebuild()
	 */
	public function rebuild($position = 0, array &$options = array(), &$detailedMessage = '')
	{
		$options['batch'] = isset($options['batch']) ? $options['batch'] : 28;
		$options['batch'] = max(1, $options['batch']);

		/* @var $userModel XenForo_Model_Stats */
		$statsModel = XenForo_Model::create('XenForo_Model_Stats');

		if ($position == 0)
		{
			// delete old stats cache if required
			if (!empty($options['delete']))
			{
				$statsModel->deleteStats();
			}

			$xenOptions = XenForo_Application::get('options');
			
			// an appropriate date from which to start... first thread, or earliest user reg?
			if ($xenOptions->th_noForo_noForum) {
			    $position = XenForo_Model::create('XenForo_Model_User')->getEarliestRegistrationDate();
			} else {
    			$position = min(
    				XenForo_Model::create('XenForo_Model_Thread')->getEarliestThreadDate(),
    				XenForo_Model::create('XenForo_Model_User')->getEarliestRegistrationDate()
    			);
	    	}
   
			// start on a 24 hour increment point
			$position = $position - $position % 86400;
		}
		else if ($position > XenForo_Application::$time)
		{
			return true;
		}

		XenForo_Db::beginTransaction();

		$endPosition = $position + $options['batch'] * 86400;

		$data = $statsModel->buildStatsData($position, $endPosition);

		XenForo_Db::commit();

		$detailedMessage = XenForo_Locale::date($position, 'absolute');

		return $endPosition;
	} /* END rebuild */
}