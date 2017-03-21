<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class VideoController extends AdminbaseController{

	protected $video_list;
	protected $players;

	public function _initialize() {
		parent::_initialize();
		$this->video_list = D('video_list');
		$this->players = M('players');
	}

	public function index() {
		$videoList = $this->video_list->select();
		// 利用选手id获取选手姓名
		foreach($videoList as $key => $value) {
			$videoList[$key]['red_name'] = $this->players->where(['id'=>$value['player_red_id']])->select()[0]['name'];
			$videoList[$key]['blue_name'] = $this->players->where(['id'=>$value['player_blue_id']])->select()[0]['name'];
			$videoList[$key]['winner_name'] = $value['winner'] == '0' ? '平局' : $value['winner'] == '1' ? $videoList[$key]['red_name'] : $videoList[$key]['blue_name'];
		}
		$this->assign('videoList', $videoList);
		$this->display();
	}

	public function add() {
		$players = $this->players->select();
		$this->assign('players', $players);
		$this->display();
	}

	public function edit() {
		if(IS_GET) {
			$id = $_GET['id'];
			$data = M('video_list')->where(['id' => $id])->select();
			$this->assign('data', $data[0]);
		}
		$players = $this->players->select();
		$this->assign('players', $players);
		$this->display();
	}

	public function addPort() {
		if(IS_POST) {
			$data = [
				'name' => $_POST['name'],
				'image' => $_POST['image'],
				'leaves' => $_POST['leaves'],
				'rounds' => $_POST['rounds'],
				'player_red_id' => $_POST['player_red_id'],
				'player_blue_id' => $_POST['player_blue_id'],
				'winner' => $_POST['winner'],
				'link' => $_POST['link']
			];
			$r = M('video_list')->add($data);
			if($r !== false) {
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}
	}

	public function editPort() {
		if(IS_POST) {
			$data = [
				'id' => $_POST['id'],
				'name' => $_POST['name'],
				'image' => $_POST['image'],
				'leaves' => $_POST['leaves'],
				'rounds' => $_POST['rounds'],
				'player_red_id' => $_POST['player_red_id'],
				'player_blue_id' => $_POST['player_blue_id'],
				'winner' => $_POST['winner'],
				'link' => $_POST['link']
			];
			$r = M('video_list')->where(['id' => $data['id']])->save($data);
			if($r !== false) {
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}

		}
	}

	public function delete() {
	
	}

}
