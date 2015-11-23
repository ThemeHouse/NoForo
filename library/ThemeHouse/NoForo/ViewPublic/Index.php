<?php

class ThemeHouse_NoForo_ViewPublic_Index extends XenForo_ViewPublic_Base
{
	public function renderHtml()
	{
		$this->_params['renderedNodes'] = XenForo_ViewPublic_Helper_Node::renderNodeTreeFromDisplayArray(
			$this, $this->_params['nodeList']
		);
	} /* END renderHtml */
}