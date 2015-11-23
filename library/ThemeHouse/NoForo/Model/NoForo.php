<?php

class ThemeHouse_NoForo_Model_NoForo extends XenForo_Model
{

    protected static $_tablesList;

    public function removeForum($option = array())
    {
        $db = $this->_getDb();

        $adminNavigationList = array(
            'createForum',
            'feeder',
            'feedlist',
            'threadPrefixes',
            'threadsPosts'
        );
        if (isset($option['no_link_forums'])) {
            $adminNavigationList[] = 'createNewLink';
        }

        $db->query('DELETE FROM xf_admin_navigation WHERE navigation_id IN (' . $db->quote($adminNavigationList) . ')');

        $db->query(
            'DELETE FROM xf_admin_permission WHERE admin_permission_id IN (' . $db->quote(array(
                'thread'
            )) . ')');

        $db->query(
            'DELETE FROM xf_admin_permission_entry WHERE admin_permission_id IN (' . $db->quote(array(
                'thread'
            )) . ')');

        $db->query(
            'DELETE FROM xf_admin_search_type WHERE search_type IN (' . $db->quote(array(
                'feed'
            )) . ')');

        $adminTemplateList = array(
            'feed_delete',
            'feed_edit',
            'feed_list',
            'forum_delete',
            'forum_edit',
            'thread_prefix_delete',
            'thread_prefix_edit',
            'thread_prefix_list',
            'thread_prefix_group_delete',
            'thread_prefix_group_edit',
            'thread_prefix_group_list',
            'thread_prefix_helper_css_class',
            'thread_prefix_helper_forums',
            'thread_prefix_helper_user_groups',
            'thread_prefix_quickset_editor',
            'thread_prefix_quickset_prefix_chooser'
        );
        if (isset($option['no_link_forums'])) {
            $adminTemplateList = array_merge($adminTemplateList,
                array(
                    'link_forum_delete',
                    'link_forum_edit'
                ));
        }
        $db->query('DELETE FROM xf_admin_template WHERE title IN (' . $db->quote($adminTemplateList) . ')');
        $db->query('DELETE FROM xf_admin_template_compiled WHERE title IN (' . $db->quote($adminTemplateList) . ')');

        $db->query(
            'DELETE FROM xf_content_type WHERE content_type IN (' . $db->quote(array(
                'post',
                'thread'
            )) . ')');

        $db->query(
            'DELETE FROM xf_content_type_field WHERE content_type IN (' . $db->quote(array(
                'post',
                'thread'
            )) . ')');
        /* @var $contentTypeModel XenForo_Model_ContentType */
        $contentTypeModel = XenForo_Model::create('XenForo_Model_ContentType');
        $contentTypeModel->rebuildContentTypeCache();

        $db->query(
            'DELETE FROM xf_cron_entry WHERE entry_id IN (' . $db->quote(array(
                'feeder'
            )) . ')');

        $db->query(
            'UPDATE xf_cron_entry
                SET cron_class = \'ThemeHouse_NoForo_CronEntry_CleanUp\'
                WHERE entry_id IN (\'cleanUpDaily\', \'cleanUpHourly\')');

        $db->query(
            'UPDATE xf_cron_entry
                SET cron_class = \'ThemeHouse_NoForo_CronEntry_Views\'
                WHERE entry_id = \'views\'');

        $db->query(
            'DELETE FROM xf_email_template WHERE title IN (' . $db->quote(
                array(
                    'watched_thread_reply',
                    'watched_thread_reply_messagetext'
                )) . ')');

        $db->query(
            'DELETE FROM xf_email_template_phrase WHERE title IN (' . $db->quote(
                array(
                    'watched_thread_reply',
                    'watched_thread_reply_messagetext'
                )) . ')');

        $db->query('DROP TABLE IF EXISTS xf_feed');
        $db->query('DROP TABLE IF EXISTS xf_feed_log');
        $db->query('DROP TABLE IF EXISTS xf_forum');
        $db->query('DROP TABLE IF EXISTS xf_forum_prefix');
        $db->query('DROP TABLE IF EXISTS xf_link_forum');

        $nodeTypeList = array(
            'Forum'
        );
        if (isset($option['no_link_forums'])) {
            $nodeTypeList[] = 'LinkForum';
        }
        $db->query('DELETE FROM xf_node WHERE node_type_id IN (' . $db->quote($nodeTypeList) . ')');
        $db->query('DELETE FROM xf_node_type WHERE node_type_id IN (' . $db->quote($nodeTypeList) . ')');
        /* @var $nodeModel XenForo_Model_Node */
        $nodeModel = XenForo_Model::create('XenForo_Model_Node');
        $nodeModel->rebuildNodeTypeCache();

        $db->query(
            'DELETE FROM xf_option WHERE option_id IN (' . $db->quote(
                array(
                    'emailWatchedThreadIncludeMessage',
                    'floodCheckLength',
                    'pollMaximumResponses',
                    'readMarkingDataLifetime',
                    'spamThreadAction'
                )) . ')');

        $db->query(
            'DELETE FROM xf_option_group_relation WHERE option_id IN (' . $db->quote(
                array(
                    'emailWatchedThreadIncludeMessage',
                    'floodCheckLength',
                    'pollMaximumResponses',
                    'readMarkingDataLifetime',
                    'spamThreadAction'
                )) . ')');

        $db->query(
            'DELETE FROM xf_permission WHERE permission_group_id IN (' . $db->quote(array(
                'forum'
            )) . ')');

        if (XenForo_Application::$versionId < 1020000) {
            $db->query(
                'DELETE FROM xf_permission_cache_global_group WHERE permission_group_id IN (' . $db->quote(
                    array(
                        'forum'
                    )) . ')');
        }

        $db->query(
            'DELETE FROM xf_permission_entry WHERE permission_group_id IN (' . $db->quote(array(
                'forum'
            )) . ')');

        $db->query(
            'DELETE FROM xf_permission_group WHERE permission_group_id IN (' . $db->quote(array(
                'forum'
            )) . ')');

        $db->query(
            'DELETE FROM xf_permission_interface_group WHERE interface_group_id IN (' . $db->quote(
                array(
                    'forumPermissions',
                    'forumModeratorPermissions'
                )) . ')');

        $phraseList = array(
            'admin_navigation_createForum',
            'admin_navigation_threadPrefixes',
            'admin_navigation_threadsPosts',
            'admin_permission_thread',
            'allow_new_messages_to_be_posted_in_this_forum',
            'all_forums',
            'all_forums_marked_as_read',
            'all_posts_from_other_threads_will_be_merged_into_this_thread',
            'all_threads_from_x_containing_messages_not_viewed',
            'all_threads_from_x_recently_updated',
            'all_threads_in_destination_forum',
            'all_unread_threads_from_x',
            'all_watched_threads',
            'any_forum',
            'applicable_forums',
            'apply_forum_options',
            'apply_prefix_to_selected_threads',
            'apply_thread_prefix',
            'apply_thread_prefix_group_options',
            'apply_thread_prefix_to_multiple_forums',
            'approve_posts',
            'approve_threads',
            'attaches_file_to_watched_thread',
            'automatically_watch_threads_you_create_or_when_you_reply',
            'cannot_merge_thread_redirection_notice',
            'configure_forum_permission_import',
            'confirm_deletion_of_forum',
            'confirm_deletion_of_link_forum',
            'confirm_deletion_of_thread_prefix',
            'confirm_deletion_of_thread_prefix_group',
            'count_messages_in_forum_toward_user_total',
            'create_new_forum',
            'create_new_thread_prefix',
            'create_new_thread_prefix_group',
            'create_thread',
            'default_thread_prefix',
            'default_thread_prefix_explain',
            'delete_forum',
            'delete_post',
            'delete_posts',
            'delete_post_by_x',
            'delete_spammers_threads',
            'delete_thread',
            'delete_threads',
            'delete_thread_prefix',
            'delete_thread_prefix_group',
            'deselect_posts',
            'deselect_threads',
            'destination_forum',
            'destination_thread',
            'display_results_as_threads',
            'edit_forum',
            'edit_post_by_x',
            'edit_thread',
            'edit_thread_prefix',
            'edit_thread_prefix_group',
            'find_all_threads_by_x',
            'forum',
            'forums',
            'forums_and_permissions',
            'forum_is_currently_closed_only_admins_may_access',
            'forum_list',
            'forum_moderator',
            'forum_options',
            'forum_statistics',
            'forum_x_marked_as_read',
            'go_to_first_message_in_thread',
            'highest_posting_members',
            'if_disabled_messages_posted_will_not_contribute_to_user_message_total',
            'if_disabled_messages_will_never_appear_in_find_new_threads',
            'if_disabled_users_not_able_post_messages_in_forum',
            'if_enabled_moderator_manually_approve_messages_posted_in_forum',
            'if_entered_url_to_forum_not_contain_id_change_breaks_urls',
            'if_specified_replace_title_that_displays_under_name_in_posts',
            'import_forums',
            'import_forum_moderators',
            'import_forum_permissions',
            'import_forum_permissions_explain',
            'import_threads_and_posts',
            'import_thread_prefixes',
            'include_forum_in_find_new_threads',
            'inline_moderation_delete_posts',
            'inline_moderation_delete_profile_posts',
            'inline_moderation_delete_threads',
            'inline_moderation_merge_posts',
            'inline_moderation_merge_threads',
            'inline_moderation_move_posts',
            'inline_moderation_move_threads',
            'inline_moderation_thread_prefix',
            'in_forum',
            'ip_information_for_post',
            'leave_redirect_for_merged_threads',
            'like_post',
            'lock_threads',
            'log_in_or_sign_up_to_post',
            'mark_all_forums_read',
            'mark_all_forums_read_button',
            'mark_all_forums_read_title',
            'mark_forums_read',
            'mark_forum_read',
            'mark_this_forum_read',
            'merge_into_post',
            'merge_posts',
            'merge_threads',
            'messages_in_threads',
            'moderate_all_messages_posted_in_this_forum',
            'moderator_log_post_approve',
            'moderator_log_post_delete_hard',
            'moderator_log_post_delete_soft',
            'moderator_log_post_edit',
            'moderator_log_post_merge_target',
            'moderator_log_post_unapprove',
            'moderator_log_post_undelete',
            'moderator_log_thread_approve',
            'moderator_log_thread_delete_hard',
            'moderator_log_thread_delete_soft',
            'moderator_log_thread_edit',
            'moderator_log_thread_lock',
            'moderator_log_thread_merge_target',
            'moderator_log_thread_move',
            'moderator_log_thread_poll_edit',
            'moderator_log_thread_post_move_source',
            'moderator_log_thread_post_move_target',
            'moderator_log_thread_prefix',
            'moderator_log_thread_stick',
            'moderator_log_thread_title',
            'moderator_log_thread_unapprove',
            'moderator_log_thread_undelete',
            'moderator_log_thread_unlock',
            'moderator_log_thread_unstick',
            'move_delete_spammers_threads',
            'move_posts',
            'move_spammers_threads',
            'move_thread',
            'move_threads',
            'move_to_forum',
            'my_thread_title',
            'my_thread_title_sentence_case',
            'my_thread_title_title_case',
            'news_feed_post_insert',
            'news_feed_post_insert_attachment',
            'news_feed_post_update',
            'news_feed_profile_post_insert',
            'news_feed_thread_insert',
            'news_feed_thread_update',
            'new_threads',
            'new_thread_title',
            'node_type_Forum',
            'no_one_has_liked_this_post_yet',
            'no_posts_matching_criteria_specified_were_found',
            'no_thread_prefixes_available_for_selected_forums',
            'no_thread_prefixes_have_been_added_yet',
            'no_thread_prefix_groups_have_been_added_yet',
            'no_unread_threads_view_recent',
            'number_of_times_something_posted_by_x_has_been_liked',
            'open_thread',
            'option_delayPostResponses',
            'option_delayPostResponses_explain',
            'option_emailWatchedThreadIncludeMessage',
            'option_emailWatchedThreadIncludeMessage_explain',
            'option_spamThreadAction',
            'option_spamThreadAction_explain',
            'order_threads_in',
            'people_may_reply_to_this_thread',
            'perform_action_with_selected_posts',
            'permalink_for_post_x',
            'permission_forum_approveUnapprove',
            'permission_forum_deleteAnyPost',
            'permission_forum_deleteAnyThread',
            'permission_forum_deleteOwnPost',
            'permission_forum_deleteOwnThread',
            'permission_forum_editAnyPost',
            'permission_forum_editOwnPost',
            'permission_forum_editOwnPostTimeLimit',
            'permission_forum_hardDeleteAnyPost',
            'permission_forum_hardDeleteAnyThread',
            'permission_forum_like',
            'permission_forum_lockUnlockThread',
            'permission_forum_manageAnyThread',
            'permission_forum_postReply',
            'permission_forum_postThread',
            'permission_forum_stickUnstickThread',
            'permission_forum_undelete',
            'permission_forum_uploadAttachment',
            'permission_forum_viewAttachment',
            'permission_forum_viewContent',
            'permission_forum_viewDeleted',
            'permission_forum_viewModerated',
            'permission_forum_viewOthers',
            'permission_forum_votePoll',
            'permission_forum_warn',
            'permission_group_forum',
            'permission_interface_forumModeratorPermissions',
            'permission_interface_forumPermissions',
            'permission_interface_postAttachmentPermissions',
            'please_close_forum_and_backup_database_before_importing',
            'please_confirm_that_you_want_to_delete_following_link_forum',
            'please_confirm_that_you_want_to_delete_following_thread_prefix',
            'please_confirm_that_you_want_to_delete_following_thread_prefix_group',
            'please_confirm_want_to_delete_forum_and_discussions',
            'please_select_more_one_post_merge',
            'please_select_more_one_thread_merge',
            'please_select_valid_forum',
            'please_specify_valid_spam_forum',
            'post',
            'postings',
            'posting_user',
            'posts',
            'post_feed_entries_as_following_user',
            'post_feed_entries_as_guest',
            'post_immediately',
            'post_in_thread_x',
            'post_likes',
            'post_moderation',
            'post_new_thread',
            'post_poll',
            'quick_set_thread_prefixes',
            'rebuild_forum_information',
            'rebuild_position_and_post_counters',
            'rebuild_thread_information',
            'recent_threads',
            'replies_to_watched_thread',
            'reply_to_thread',
            'reply_to_watched_thread_x',
            'report_post',
            'report_post_title',
            'requested_forum_not_found',
            'requested_post_not_found',
            'requested_thread_not_found',
            'return_to_forum_home_page',
            'save_forum',
            'save_thread_prefix',
            'save_thread_prefix_group',
            'search_child_forums_as_well',
            'search_forums',
            'search_in_forums',
            'search_only_in_thread',
            'search_this_forum',
            'search_this_forum_only',
            'search_this_thread_only',
            'search_threads_and_posts',
            'search_threads_started_by_this_member_only',
            'selected_posts',
            'selected_threads',
            'select_deselect_all_posts_on_this_page',
            'select_deselect_all_threads_on_this_page',
            'select_destination_forum_prompt',
            'select_forum_for_feed',
            'select_for_thread_moderation',
            'select_this_post',
            'select_this_post_by_x',
            'select_thread',
            'set_thread_status',
            'showing_threads_x_to_y_of_z',
            'show_all_watched_threads',
            'show_deleted_posts',
            'show_only_threads_prefixed_by_x',
            'someone_directly_quotes_one_of_your_messages_in_thread',
            'someone_likes_one_of_your_messages_in_thread',
            'someone_replies_and_attaches_a_file_to_a_thread_you_are_watching',
            'someone_replies_to_thread_you_are_watching',
            'sort_threads_by',
            'sticky_threads_appear_at_top_of_first_page_of_list_of_threads',
            'stick_threads',
            'stop_watching_this_thread',
            'stop_watching_threads',
            'style_property_discussionListLastPostWidth_description_master',
            'style_property_discussionListLastPostWidth_master',
            'style_property_nodeIconForumUnread_description_master',
            'style_property_nodeIconForumUnread_master',
            'style_property_nodeIconForum_description_master',
            'style_property_nodeIconForum_master',
            'style_property_nodeLastPost_description_master',
            'style_property_nodeLastPost_master',
            'style_property_threadListDescriptions_description_master',
            'style_property_threadListDescriptions_master',
            'sub_forums',
            'there_more_posts_to_display',
            'there_no_threads_to_display',
            'this_is_first_post_in_thread',
            'this_is_list_of_all_threads_that_you_watching',
            'this_is_list_of_x_most_recently_updated_threads_unread_replies',
            'this_thread_started_by_x_has_been_deleted',
            'thread',
            'threads',
            'threads_below_not_been_updated_since_last_visit_have_unread',
            'thread_by',
            'thread_creation_time',
            'thread_display_options',
            'thread_moderation',
            'thread_prefixes',
            'thread_prefixes_will_be_disassociated',
            'thread_prefix_group',
            'thread_prefix_groups',
            'thread_starter',
            'thread_status',
            'thread_title',
            'thread_tools',
            'total_messages_posted_by_x',
            'unapprove_posts',
            'unapprove_threads',
            'undelete_posts',
            'undelete_threads',
            'unlike_post',
            'unlock_threads',
            'unread_watched_threads',
            'unstick_threads',
            'unwatch_thread',
            'upgrade_is_pending_forum_only_accessible_in_debug',
            'users_redirected_to_url_when_click_on_link_forum',
            'user_has_posted_at_least_x_messages',
            'user_has_posted_no_more_than_x_messages',
            'viewing_forum',
            'viewing_forum_list',
            'viewing_thread',
            'view_postings',
            'view_this_thread',
            'view_to_first_message_in_thread',
            'watched_threads',
            'watched_thread_email_html_footer_1',
            'watched_thread_email_html_footer_2',
            'watched_thread_reply_email_html',
            'watched_thread_reply_email_text',
            'watched_thread_reply_messagetext_email_text',
            'watch_this_thread',
            'watch_this_thread_sentence',
            'watch_thread',
            'watch_threads_when_creating_or_replying',
            'watch_thread_button',
            'which_forums_do_you_want_to_mark_as_read',
            'will_slow_process_down_only_needed_if_posts_in_incorrect_order',
            'x_attached_a_file_to_thread_y_may_be_more',
            'x_has_not_posted_any_content_recently',
            'x_liked_your_post_in_the_thread_y',
            'x_liked_ys_post_in_the_thread_z',
            'x_quoted_your_post_in_thread_y',
            'x_replied_to_thread_y_may_be_more',
            'x_threads_will_be_deleted_when_these_posts_deleted',
            'your_message_has_been_posted',
            'your_posts',
            'your_threads',
            'your_thread_has_been_posted',
            'you_are_watching_this_thread_use_button_to_stop',
            'you_do_not_have_any_watched_threads_that_unread',
            'you_have_posted_x_messages_in_this_thread',
            'you_may_not_perform_this_action_because_forum_does_not_allow_posting',
            'you_not_watching_any_threads',
            'you_sure_you_want_to_delete_x_posts',
            'you_sure_you_want_to_delete_x_threads',
            'you_sure_you_want_to_like_this_post',
            'you_sure_you_want_to_mark_all_forums_read',
            'you_sure_you_want_to_mark_this_forum_read',
            'you_sure_you_want_to_merge_x_posts_together',
            'you_sure_you_want_to_merge_x_threads',
            'you_sure_you_want_to_move_x_posts_to_new_thread',
            'you_sure_you_want_to_move_x_threads',
            'you_sure_you_want_to_prefix_x_threads',
            'you_sure_you_want_to_unlike_this_post'
        );
        if (isset($option['no_link_forums'])) {
            $phraseList = array_merge($phraseList,
                array(
                    'create_new_link_forum',
                    'delete_link_forum',
                    'edit_link_forum',
                    'node_type_LinkForum',
                    'requested_link_forum_not_found',
                    'save_link_forum'
                ));
        }
        $db->query('DELETE FROM xf_phrase WHERE title IN (' . $db->quote($phraseList) . ')');
        $db->query('DELETE FROM xf_phrase_compiled WHERE title IN (' . $db->quote($phraseList) . ')');
        $db->query('DELETE FROM xf_phrase_map WHERE title IN (' . $db->quote($phraseList) . ')');

        $db->query('DROP TABLE IF EXISTS xf_poll');
        $db->query('DROP TABLE IF EXISTS xf_poll_response');
        $db->query('DROP TABLE IF EXISTS xf_poll_vote');
        $db->query('DROP TABLE IF EXISTS xf_post');

        $routePrefixList = array(
            'feeds',
            'forums',
            'thread-prefixes',
            'threads',
            'watched'
        );
        if (isset($option['no_link_forums'])) {
            $routePrefixList[] = 'link-forums';
        }
        $db->query('DELETE FROM xf_route_prefix WHERE original_prefix IN (' . $db->quote($routePrefixList) . ')');
        /* @var $routePrefixModel XenForo_Model_RoutePrefix */
        $routePrefixModel = XenForo_Model::create('XenForo_Model_RoutePrefix');
        $routePrefixModel->rebuildRoutePrefixCache();

        $db->query(
            'DELETE FROM xf_stats_daily WHERE stats_type IN (' . $db->quote(array(
                'post',
                'thread'
            )) . ')');

        $templateList = array(
            'ad_forum_view_above_node_list',
            'ad_forum_view_above_thread_list',
            'ad_thread_list_below_stickies',
            'ad_thread_view_above_messages',
            'ad_thread_view_below_messages',
            'alert_post_insert',
            'alert_post_insert_attachment',
            'alert_post_like',
            'alert_post_quote',
            'find_new_threads',
            'forum_list',
            'forum_mark_read',
            'forum_view',
            'forum_view_legacy_controls',
            'inline_mod_controls_thread',
            'inline_mod_post_delete',
            'inline_mod_post_merge',
            'inline_mod_post_move',
            'inline_mod_thread_delete',
            'inline_mod_thread_helper_redirect',
            'inline_mod_thread_merge',
            'inline_mod_thread_move',
            'inline_mod_thread_prefix',
            'news_feed_item_thread_insert',
            'node_forum.css',
            'node_forum_level_1',
            'node_forum_level_2',
            'node_forum_level_n',
            'polls.css',
            'poll_block',
            'poll_block_result',
            'poll_block_vote',
            'post',
            'post_delete',
            'post_deleted',
            'post_deleted_placeholder',
            'post_edit',
            'post_edit_inline',
            'post_edit_preview',
            'post_ip',
            'post_like',
            'post_likes',
            'post_moderated',
            'post_permalink',
            'post_report',
            'report_post_content',
            'search_bar_forum_only',
            'search_form_post',
            'search_form_post.css',
            'search_result_post',
            'search_result_thread',
            'thread_create',
            'thread_create_preview',
            'thread_delete',
            'thread_edit',
            'thread_fields_move',
            'thread_fields_status',
            'thread_list',
            'thread_list_item',
            'thread_list_item_deleted',
            'thread_list_item_edit',
            'thread_list_item_edit.css',
            'thread_list_item_preview',
            'thread_move',
            'thread_poll_edit',
            'thread_poll_results',
            'thread_poll_voters',
            'thread_prefixes.css',
            'thread_reply',
            'thread_reply_new_posts',
            'thread_reply_preview',
            'thread_view',
            'thread_view.css',
            'thread_watch',
            'title_prefix_edit',
            'watch_threads',
            'watch_threads_all',
            'watch_threads_list_item'
        );
        if (isset($option['no_link_forums'])) {
            $templateList = array_merge($templateList,
                array(
                    'node_link.css',
                    'node_link_level_1',
                    'node_link_level_2',
                    'node_link_level_n'
                ));
        }
        $db->query('DELETE FROM xf_template WHERE title IN (' . $db->quote($templateList) . ')');
        $db->query('DELETE FROM xf_template_compiled WHERE title IN (' . $db->quote($templateList) . ')');
        $db->query('DELETE FROM xf_template_map WHERE title IN (' . $db->quote($templateList) . ')');

        $db->query('DROP TABLE IF EXISTS xf_thread');
        $db->query('DROP TABLE IF EXISTS xf_thread_prefix');
        $db->query('DROP TABLE IF EXISTS xf_thread_prefix_group');
        $db->query('DROP TABLE IF EXISTS xf_thread_read');
        $db->query('DROP TABLE IF EXISTS xf_thread_redirect');
        $db->query('DROP TABLE IF EXISTS xf_thread_reply_ban');
        $db->query('DROP TABLE IF EXISTS xf_thread_user_post');
        $db->query('DROP TABLE IF EXISTS xf_thread_view');
        $db->query('DROP TABLE IF EXISTS xf_thread_watch');

        $db->query('DELETE FROM xf_trophy WHERE trophy_id < 5');

        // RESOURCE MANAGER
        if ($this->_isTableExists('xf_resource')) {
            $db->query('UPDATE xf_resource SET discussion_thread_id = 0');
        }
        if ($this->_isTableExists('xf_resource_category')) {
            $db->query('UPDATE xf_resource_category SET thread_node_id = 0,
                thread_prefix_id = 0');
        }
    } /* END removeForum */

    public function rebuildForum()
    {
        $db = $this->_getDb();

        $tables = XenForo_Install_Data_MySql::getTables();
        $data = XenForo_Install_Data_Mysql::getData();

        $db->query(
            "
            INSERT IGNORE INTO xf_admin_search_type
                (search_type, handler_class, display_order)
            VALUES
                ('feed', 'XenForo_AdminSearchHandler_Feed', 310)
        ");

        $db->query(
            "
            INSERT IGNORE INTO xf_content_type
                (content_type, addon_id, fields)
            VALUES
                ('post', 'XenForo', ''),
                ('thread', 'XenForo', '')
        ");

        $db->query(
            "
            INSERT IGNORE INTO xf_content_type_field
                (content_type, field_name, field_value)
            VALUES
                ('post', 'news_feed_handler_class', 'XenForo_NewsFeedHandler_DiscussionMessage_Post'),
                ('post', 'alert_handler_class', 'XenForo_AlertHandler_DiscussionMessage_Post'),
                ('post', 'search_handler_class', 'XenForo_Search_DataHandler_Post'),
                ('post', 'attachment_handler_class', 'XenForo_AttachmentHandler_Post'),
                ('post', 'like_handler_class', 'XenForo_LikeHandler_Post'),
                ('post', 'report_handler_class', 'XenForo_ReportHandler_Post'),
                ('post', 'moderation_queue_handler_class', 'XenForo_ModerationQueueHandler_Post'),
                ('post', 'spam_handler_class', 'XenForo_SpamHandler_Post'),
                ('post', 'stats_handler_class', 'XenForo_StatsHandler_Post'),
                ('post', 'moderator_log_handler_class', 'XenForo_ModeratorLogHandler_Post'),
                ('post', 'warning_handler_class', 'XenForo_WarningHandler_Post'),

                ('thread', 'news_feed_handler_class', 'XenForo_NewsFeedHandler_Discussion_Thread'),
                ('thread', 'search_handler_class', 'XenForo_Search_DataHandler_Thread'),
                ('thread', 'moderation_queue_handler_class', 'XenForo_ModerationQueueHandler_Thread'),
                ('thread', 'spam_handler_class', 'XenForo_SpamHandler_Thread'),
                ('thread', 'stats_handler_class', 'XenForo_StatsHandler_Thread'),
                ('thread', 'moderator_log_handler_class', 'XenForo_ModeratorLogHandler_Thread')
        ");

        $db->query(
            'DELETE FROM xf_cron_entry WHERE entry_id IN (' . $db->quote(array(
                'cleanUpDaily', 'cleanUpHourly', 'views'
            )) . ')');

        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_feed']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_feed_log']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_forum']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_forum_prefix']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_link_forum']));

        $db->query(
            "
            INSERT IGNORE INTO xf_node_type
                (node_type_id, handler_class, controller_admin_class, datawriter_class, permission_group_id,
                        moderator_interface_group_id, public_route_prefix)
            VALUES
                ('Forum', 'XenForo_NodeHandler_Forum', 'XenForo_ControllerAdmin_Forum', 'XenForo_DataWriter_Forum', 'forum', 'forumModeratorPermissions', 'forums'),
                ('LinkForum', 'XenForo_NodeHandler_LinkForum', 'XenForo_ControllerAdmin_LinkForum', 'XenForo_DataWriter_LinkForum', 'linkForum', '', 'link-forums')
        ");

        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_poll']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_poll_response']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_poll_vote']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_post']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_prefix']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_prefix_group']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_read']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_redirect']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_user_post']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_view']));
        $db->query(str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $tables['xf_thread_watch']));

        $db->query($data['xf_trophy']);
    } /* END rebuildForum */ /* rebuildForum */

    /**
     *
     * @param string $addOnId
     */
    protected function _rebuildPermissionsForAddOn($addOnId)
    {
        /* @var $permissionModel XenForo_Model_Permission */
        $permissionModel = XenForo_Model::create('XenForo_Model_Permission');

        $fileName = XenForo_Application::getInstance()->getRootDir() . '/install/data/addon-' . $addOnId . '.xml';

        if (!file_exists($fileName) || !is_readable($fileName)) {
            // TODO add a more appropriate phrase?
            throw new XenForo_Exception(new XenForo_Phrase('file_not_found'), true);
        }

        try {
            $document = new SimpleXMLElement($fileName, 0, true);
        } catch (Exception $e) {
            throw new XenForo_Exception(
                // TODO add a more appropriate phrase?
                new XenForo_Phrase('provided_file_was_not_valid_xml_file'), true);
        }

        $this->getModelFromCache('XenForo_Model_Permission')->importPermissionsAddOnXml($document->permissions,
            $addOnId);
    } /* END _rebuildPermissionsForAddOn */

    public function isNoLinkForums()
    {
        return (!$this->_isTableExists('xf_link_forum'));
    } /* END isNoLinkForums */

    /**
     *
     * @param string $tableName
     * @return boolean
     */
    protected function _isTableExists($tableName)
    {
        if (!$this->_db) {
            $this->_db = $this->_getDb();
        }
        if (!self::$_tablesList) {
            self::$_tablesList = array_map('strtolower', $this->_db->listTables());
        }
        return in_array(strtolower($tableName), self::$_tablesList);
    } /* END _isTableExists */
}