<?php

/**
 *
 * @see XenForo_ControllerAdmin_User
 */
class ThemeHouse_NoForo_Extend_XenForo_ControllerAdmin_User extends XFCP_ThemeHouse_NoForo_Extend_XenForo_ControllerAdmin_User
{

    /**
     *
     * @see XenForo_ControllerAdmin_User::actionAdd()
     */
    public function actionAdd()
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noMessageCount) {
            $user = array(
                'user_id' => 0,
                'timezone' => XenForo_Application::get('options')->guestTimeZone,
                'user_group_id' => XenForo_Model_User::$defaultRegisteredGroupId,
                'style_id' => 0,
                'language_id' => XenForo_Application::get('options')->defaultLanguageId,
                'user_state' => 'valid',
                'enable_rte' => 1,
                'like_count' => 0,
                'trophy_points' => 0
            );
            $user = array_merge($user, XenForo_Application::get('options')->registrationDefaults);

            return $this->_getUserAddEditResponse($user);
        }

        return parent::actionAdd();
    } /* END actionAdd */

    /**
     * Inserts a new user or updates an existing one.
     *
     * @return XenForo_ControllerResponse_Abstract
     */
    public function actionSave()
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_noForo_noMessageCount) {
            $this->_assertPostOnly();

            $userId = $this->_input->filterSingle('user_id', XenForo_Input::UINT);

            if ($userId) {
                $user = $this->_getUserOrError($userId);
                $this->getHelper('Admin')->checkSuperAdminEdit($user);

                if ($this->_getUserModel()->isUserSuperAdmin($user)) {
                    $visitorPassword = $this->_input->filterSingle('visitor_password', XenForo_Input::STRING);
                    $this->getHelper('Admin')->assertVisitorPasswordCorrect($visitorPassword);
                }
            }

            $userInput = $this->_input->filter(
                array(

                    // essentials
                    'username' => XenForo_Input::STRING,
                    'email' => XenForo_Input::STRING,

                    'user_group_id' => XenForo_Input::UINT,
                    'user_state' => XenForo_Input::STRING,
                    'is_discouraged' => XenForo_Input::UINT,

                    // personal details
                    'gender' => XenForo_Input::STRING,
                    'dob_day' => XenForo_Input::UINT,
                    'dob_month' => XenForo_Input::UINT,
                    'dob_year' => XenForo_Input::UINT,
                    'location' => XenForo_Input::STRING,
                    'occupation' => XenForo_Input::STRING,

                    // profile info
                    'custom_title' => XenForo_Input::STRING,
                    'homepage' => XenForo_Input::STRING,
                    'about' => XenForo_Input::STRING,
                    'signature' => XenForo_Input::STRING,

                    'like_count' => XenForo_Input::UINT,
                    'trophy_points' => XenForo_Input::UINT,

                    // preferences
                    'style_id' => XenForo_Input::UINT,
                    'language_id' => XenForo_Input::UINT,
                    'timezone' => XenForo_Input::STRING,
                    'content_show_signature' => XenForo_Input::UINT,
                    'enable_rte' => XenForo_Input::UINT,

                    // privacy
                    'visible' => XenForo_Input::UINT,
                    'receive_admin_email' => XenForo_Input::UINT,
                    'show_dob_date' => XenForo_Input::UINT,
                    'show_dob_year' => XenForo_Input::UINT,
                    'allow_view_profile' => XenForo_Input::STRING,
                    'allow_post_profile' => XenForo_Input::STRING,
                    'allow_send_personal_conversation' => XenForo_Input::STRING,
                    'allow_view_identities' => XenForo_Input::STRING,
                    'allow_receive_news_feed' => XenForo_Input::STRING
                ));

            $secondaryGroupIds = $this->_input->filterSingle('secondary_group_ids', XenForo_Input::UINT,
                array(
                    'array' => true
                ));

            $userInput['about'] = XenForo_Helper_String::autoLinkBbCode($userInput['about']);

            if ($this->_input->filterSingle('clear_status', XenForo_Input::UINT)) {
                //TODO: clear status
            }

            /* @var $writer XenForo_DataWriter_User */
            $writer = XenForo_DataWriter::create('XenForo_DataWriter_User');
            if ($userId) {
                $writer->setExistingData($userId);
            }
            $writer->setOption(XenForo_DataWriter_User::OPTION_ADMIN_EDIT, true);

            $writer->bulkSet($userInput);
            $writer->setSecondaryGroups($secondaryGroupIds);

            $password = $this->_input->filterSingle('password', XenForo_Input::STRING);
            if ($password !== '') {
                $writer->setPassword($password);
            }

            $customFields = $this->_input->filterSingle('custom_fields', XenForo_Input::ARRAY_SIMPLE);
            $customFieldsShown = $this->_input->filterSingle('custom_fields_shown', XenForo_Input::STRING,
                array(
                    'array' => true
                ));
            $writer->setCustomFields($customFields, $customFieldsShown);

            $writer->save();

            $userId = $writer->get('user_id');

            // TODO: redirect to previous search if possible?


            return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
                XenForo_Link::buildAdminLink('users/search', null, array(
                    'last_user_id' => $userId
                )) . $this->getLastHash($userId));
        }

        return parent::actionSave();
    } /* END actionSave */
}