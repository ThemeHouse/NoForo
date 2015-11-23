<?php

/**
 *
 * @see XenForo_ControllerPublic_Member
 */
class ThemeHouse_NoForo_Extend_XenForo_ControllerPublic_Member extends XFCP_ThemeHouse_NoForo_Extend_XenForo_ControllerPublic_Member
{

    /**
     *
     * @see XenForo_ControllerPublic_Member::actionIndex()
     */
    public function actionIndex()
    {
        if (XenForo_Application::$versionId < 1020000) {
            $xenOptions = XenForo_Application::get('options');

            if ($xenOptions->th_noForo_noMessageCount) {
                $userId = $this->_input->filterSingle('user_id', XenForo_Input::UINT);
                if ($userId) {
                    return $this->responseReroute(__CLASS__, 'member');
                } elseif ($this->_input->inRequest('user_id')) {
                    return $this->responseError(new XenForo_Phrase('posted_by_guest_no_profile'));
                }

                $userModel = $this->_getUserModel();

                $username = $this->_input->filterSingle('username', XenForo_Input::STRING);
                if ($username !== '') {
                    $user = $userModel->getUserByName($username);
                    if ($user) {
                        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
                            XenForo_Link::buildPublicLink('members', $user));
                    } else {
                        $userNotFound = true;
                    }
                } else {
                    $userNotFound = false;
                }

                $page = $this->_input->filterSingle('page', XenForo_Input::UINT);
                $usersPerPage = XenForo_Application::get('options')->membersPerPage;

                $criteria = array(
                    'user_state' => 'valid',
                    'is_banned' => 0
                );

                // users for the member list
                $users = $userModel->getUsers($criteria,
                    array(
                        'join' => XenForo_Model_User::FETCH_USER_FULL,
                        'perPage' => $usersPerPage,
                        'page' => $page
                    ));

                // most recent registrations
                $latestUsers = $userModel->getLatestUsers($criteria,
                    array(
                        'limit' => 8
                    ));

                $viewParams = array(
                    'users' => $users,

                    'totalUsers' => $userModel->countUsers($criteria),
                    'page' => $page,
                    'usersPerPage' => $usersPerPage,

                    'latestUsers' => $latestUsers,

                    'userNotFound' => $userNotFound
                );

                return $this->responseView('XenForo_ViewPublic_Member_List', 'member_list', $viewParams);
            }
        } else {
            $type = $this->_input->filterSingle('type', XenForo_Input::STRING);

            if (!$type) {
                $this->_request->setParam('type', 'likes');
            }
        }

        return parent::actionIndex();
    } /* END actionIndex */
}