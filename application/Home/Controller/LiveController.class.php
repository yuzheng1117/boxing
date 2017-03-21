<?php
namespace Home\Controller;
use Common\Controller\MobliebaseController;
class LiveController extends MobliebaseController{
	function _initialize() {
		parent::_initialize();
	}
	// 视频列表页面
	public function live() {
		$this->display();
	}
}
