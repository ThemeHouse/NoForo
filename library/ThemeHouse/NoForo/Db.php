<?php

class ThemeHouse_NoForo_Db
{

    protected $_db = null;

    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
    } /* END __construct */

    public function __call($name, $arguments)
    {
        return call_user_func_array(array(
            $this->_db,
            $name
        ), $arguments);
    } /* END __call */

    public function delete($table, $where = '')
    {
        $removedTables = array(
            'xf_feed',
            'xf_feed_log',
            'xf_forum',
            'xf_forum_prefix',
            'xf_link_forum',
            'xf_poll',
            'xf_poll_response',
            'xf_poll_vote',
            'xf_post',
            'xf_thread',
            'xf_thread_prefix',
            'xf_thread_prefix_group',
            'xf_thread_read',
            'xf_thread_redirect',
            'xf_thread_reply_ban',
            'xf_thread_user_post',
            'xf_thread_view',
            'xf_thread_watch'
        );

        if (in_array($table, $removedTables)) {
            return;
        }

        return $this->_db->delete($table, $where);
    } /* END delete */
}