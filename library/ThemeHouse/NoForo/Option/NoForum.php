<?php

class ThemeHouse_NoForo_Option_NoForum
{
    /**
     * Renders the remove forum option.
     *
     * @param XenForo_View $view View object
     * @param string $fieldPrefix Prefix for the HTML form field name
     * @param array $preparedOption Prepared option info
     * @param boolean $canEdit True if an "edit" link should appear
     *
     * @return XenForo_Template_Abstract Template object
     */
    public static function render(XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    {
        if (!is_array($preparedOption['option_value'])) {
            $preparedOption['option_value'] = array(
                'no_forum' => true,
                'no_link_forums' => true,
            );
        } else if (empty($preparedOption['option_value'])) {
            $preparedOption['option_value'] = array(
                'no_forum' => false,
                'no_link_forums' => false,
            );
        }

        return XenForo_ViewAdmin_Helper_Option::renderOptionTemplateInternal(
            'th_option_template_noforum_noforo', $view, $fieldPrefix, $preparedOption, $canEdit
        );
    } /* END render */

    public static function validateNoForum(&$option, XenForo_DataWriter $dw, $fieldName)
    {
        $_request = new Zend_Controller_Request_Http();
        $_input = new XenForo_Input($_request);
        
        $optionsInput = $_input->filterSingle('options', XenForo_Input::ARRAY_SIMPLE);
        $sandbox = isset($optionsInput['th_noForo_sandbox']);
        
        if (!isset($option['no_forum'])) {
            $option = array();
        }

        if ($sandbox) {
            return true;
        }

        /* @var $noForoModel ThemeHouse_NoForo_Model_NoForo */
        $noForoModel = XenForo_Model::create('ThemeHouse_NoForo_Model_NoForo');

        if (isset($option['no_forum'])) {
            if (!isset($option['no_link_forums'])) {
                $option['no_link_forums'] = $noForoModel->isNoLinkForums();
            }
        }

        $option = array_filter($option);
        if ($option) {
            $noForoModel->removeForum($option);
        } else {
            $noForoModel->rebuildForum();
        }

        return true;
    } /* END validateNoForum */

    protected static function _getOptions()
    {
        return array(
            'no_forum' => 0x01,
            'no_link_forums' => 0x02,
        );
    } /* END _getOptions */
}