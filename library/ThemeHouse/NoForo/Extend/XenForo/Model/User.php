<?php

/**
 *
 * @see XenForo_Model_User
 */
class ThemeHouse_NoForo_Extend_XenForo_Model_User extends XFCP_ThemeHouse_NoForo_Extend_XenForo_Model_User
{

    /**
     *
     * @see XenForo_Model_User::__construct()
     */
    public function __construct()
    {
        parent::__construct();

        if (isset(XenForo_Model_User::$userContentChanges)) {
            unset(XenForo_Model_User::$userContentChanges['xf_poll_vote']);
            unset(XenForo_Model_User::$userContentChanges['xf_post']);
            unset(XenForo_Model_User::$userContentChanges['xf_thread']);
            unset(XenForo_Model_User::$userContentChanges['xf_forum']);
            unset(XenForo_Model_User::$userContentChanges['xf_thread_reply_ban']);
            unset(XenForo_Model_User::$userContentChanges['xf_thread_user_post']);
            unset(XenForo_Model_User::$userContentChanges['xf_thread_watch']);
        }
    } /* END __construct */

    /**
     *
     * @see XenForo_Model_User::prepareUserOrderOptions()
     */
    public function prepareUserOrderOptions(array &$fetchOptions, $defaultOrderSql = '')
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noMessageCount) {
            $choices = array(
                'username' => 'user.username',
                'register_date' => 'user.register_date',
                'last_activity' => 'user.last_activity'
            );
            return $this->getOrderByClause($choices, $fetchOptions, $defaultOrderSql);
        }

        return parent::prepareUserOrderOptions($fetchOptions, $defaultOrderSql);
    } /* END prepareUserOrderOptions */

    /**
     *
     * @see XenForo_Model_User::couldBeSpammer()
     */
    public function couldBeSpammer(array $user, &$errorKey = '')
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noMessageCount) {
            // self
            if ($user['user_id'] == XenForo_Visitor::getUserId()) {
                $errorKey = 'sorry_dave';
                return false;
            }

            // staff
            if ($user['is_admin'] || $user['is_moderator']) {
                $errorKey = 'spam_cleaner_no_admins_or_mods';
                return false;
            }

            $criteria = XenForo_Application::get('options')->spamUserCriteria;

            if ($criteria['register_date'] &&
                 $user['register_date'] < (XenForo_Application::$time - $criteria['register_date'] * 86400)) {
                $errorKey = array(
                    'spam_cleaner_registered_too_long',
                    'register_days' => $criteria['register_date']
                );
                return false;
            }

            if ($criteria['like_count'] && $user['like_count'] > $criteria['like_count']) {
                $errorKey = array(
                    'spam_cleaner_too_many_likes',
                    'like_count' => $criteria['like_count']
                );
                return false;
            }

            return true;
        }

        return parent::couldBeSpammer($user, $errorKey);
    } /* END couldBeSpammer */
}