<?php

/**
 *
 * @see XenForo_DataWriter_User
 */
class ThemeHouse_NoForo_Extend_XenForo_DataWriter_User extends XFCP_ThemeHouse_NoForo_Extend_XenForo_DataWriter_User
{

    /**
     *
     * @see XenForo_DataWriter_User::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();

        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noMessageCount) {
            unset($fields['xf_user']['message_count']);
        }

        return $fields;
    } /* END _getFields */

    /**
     *
     * @see XenForo_DataWriter_User::_postDelete()
     */
    protected function _postDelete()
    {
        $oldDb = $this->_db;

        $this->_db = new ThemeHouse_NoForo_Db($this->_db);

        parent::_postDelete();

        $this->_db = $oldDb;
    } /* END _postDelete */
}