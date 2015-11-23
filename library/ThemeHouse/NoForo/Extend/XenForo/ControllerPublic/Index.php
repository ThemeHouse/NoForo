<?php

/**
 *
 * @see XenForo_ControllerPublic_Index
 */
class ThemeHouse_NoForo_Extend_XenForo_ControllerPublic_Index extends XFCP_ThemeHouse_NoForo_Extend_XenForo_ControllerPublic_Index
{

    /**
     *
     * @see XenForo_ControllerPublic_Index::actionIndex()
     */
    public function actionIndex()
    {
        if (XenForo_Application::$versionId < 1020000) {
            $xenOptions = XenForo_Application::get('options');

            if ($xenOptions->get('th_noForo_noForum')) {
                $this->canonicalizeRequestUrl(XenForo_Link::buildPublicLink('index'));

                $viewParams = array(
                    'nodeList' => $this->_getNodeModel()->getNodeDataForListDisplay(false, 0),
                    'onlineUsers' => $this->_getSessionActivityList(),
                    'boardTotals' => $this->_getBoardTotals()
                );

                return $this->responseView('ThemeHouse_NoForo_ViewPublic_Index', 'index', $viewParams);
            }
        }

        return parent::actionIndex();
    } /* END actionIndex */
}