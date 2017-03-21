<?php
namespace Home\Controller;
use Common\Controller\MobliebaseController;
class VideoController extends MobliebaseController{
	function _initialize() {
		parent::_initialize();
	}
	// 视频列表页面
	public function video_list() {
		$video_list = M('video_list')->select();
		$players_model = M('players');
		foreach($video_list as $key => $value) {
			$video_list[$key]['red_name'] = $players_model->where(['id'=>$value['player_red_id']])->select()[0]['name'];
			$video_list[$key]['blue_name'] = $players_model->where(['id'=>$value['player_blue_id']])->select()[0]['name'];
			$video_list[$key]['winner_name'] = $value['winner'] == '0' ? '平局' : $value['winner'] == '1' ? $video_list[$key]['red_name'] : $video_list[$key]['blue_name'];
		}
		$this->assign('video_list', $video_list);
		$this->display();
	}
}
