<?php

class ThemeHouse_NoForo_Listener_TemplatePostRender extends ThemeHouse_Listener_TemplatePostRender
{

    protected function _getTemplates()
    {
        return array(
            'application_splash',
            'tools_rebuild',
            'resource_category_edit'
        );
    } /* END _getTemplates */

    public static function templatePostRender($templateName, &$content, array &$containerData,
        XenForo_Template_Abstract $template)
    {
        $templatePostRender = new ThemeHouse_NoForo_Listener_TemplatePostRender($templateName, $content, $containerData,
            $template);
        list($content, $containerData) = $templatePostRender->run();
    } /* END templatePostRender */

    protected function _applicationSplash()
    {
        $codeSnippet = $this->_render('th_application_splash_noforo');
        $this->_replaceAtCodeSnippet($codeSnippet);
    } /* END _applicationSplash */

    protected function _toolsRebuild()
    {
        $codeSnippet = $this->_render('th_tools_rebuild_noforo');
        $this->_replaceAtCodeSnippet($codeSnippet);
    } /* END _toolsRebuild */

    protected function _resourceCategoryEdit()
    {
        $pattern = '#<dl class="ctrlUnit">\s*<dt>' . new XenForo_Phrase('automatically_create_thread_in_forum') .
             ':</dt>.*</dl>\s*<div id="PrefixContainer">.*</div>#Us';
        $replacement = '';
        $this->_contents = preg_replace($pattern, $replacement, $this->_contents);
    } /* END _resourceCategoryEdit */
}