<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class PlayersController extends AdminbaseController{

	protected $player_model;

	public function _initialize() {
		parent::_initialize();
		$this->players_model = D("players");
	}
	
	// 运动员列表页面
	public function index() {
		$players = $this->players_model->select();
		foreach($players as $key => $value){
			$players[$key]['age'] = (int)date('Y', time()) - (int)$value['birth'];
		}
		$this->assign("players", $players);
		$this->display();
	}

	// 运动员增加页面
	public function add() {
		$this->display();
	}
	// 运动员增加接口
	public function addPort() {
		if(IS_POST) {
			$data = [
				'name' => $_POST['name'],
				'nick_name' => $_POST['nick_name'],
				'birth' => $_POST['birth'],
				'place' => $_POST['place'],
				'height' => $_POST['height'],
				'weight' => $_POST['weight'],
				'is_del' => $_POST['is_del']
			];
			$r = M("players")->add($data);
			if($r !== false) {
				$this->success('保存成功');
			}else{
				$this->error('保存失败');
			}
		}
	}
	// 运动员编辑页面
	public function edit() {
		if(IS_GET) {
			$id = $_GET['id'];
			$data = D('players')->where(['id' => $id])->select();
			$this->assign('data', $data[0]);
		}
		$this->display();
	}
	// 运动员编辑接口
	public function editPort() {
		if(IS_POST) {
			$data = [
				'id' => $_POST['id'],
				'name' => $_POST['name'],
				'nick_name' => $_POST['nick_name'],
				'birth' => $_POST['birth'],
				'place' => $_POST['place'],
				'height' => $_POST['height'],
				'weight' => $_POST['weight'],
				'is_del' => $_POST['is_del']
			];
			$r = D('players')->where(['id' => $data['id']])->save($data);
			if($r !== false) {
				$this->success('保存成功');
			}else{
				$this->error('保存失败');
			}
		}
	}
	// 运动员删除接口
	public function delete() {
		$this->display();
	}
}
