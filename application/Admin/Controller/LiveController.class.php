<?php

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class LiveController extends AdminbaseController {
	
	protected $live_model;
	protected $player_model;

	public function _initialize() {
		parent::_initialize();	
		$this->live_model = M('live_list');
		$this->player_model = M('players');
	}

	public function index() {
		$live_list = $this->live_model->select();

		foreach($live_list as $key => $value) {
			$live_list[$key]['red_name'] = $this->player_model->where(['id'=>$value['player_red_id']])->select()[0]['name'];
			$live_list[$key]['blue_name'] = $this->player_model->where(['id'=>$value['player_blue_id']])->select()[0]['name'];
		}
		$this->assign('liveList', $live_list);
		$this->display();
	}

	public function add() {
		$this->display();
	}

	public function edit() {
		$id = 
		$this->display();
	}
}
