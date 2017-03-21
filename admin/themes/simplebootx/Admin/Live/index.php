<admintpl file="header" />
	<style>
		th, td{
			text-align: center !important;
		}
	</style>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="{:U('Live/index')}">直播列表</a></li>
			<li><a href="{:U('Live/add')}">增加直播</a></li>
		</ul>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>直播id</th>
					<th>直播名称</th>
					<th>级别</th>
					<th>回合数</th>
					<th>红方选手(基础数据)</th>
					<th>蓝方选手(基础数据)</th>
					<th>观众基础数据</th>
					<th>赏金</th>
					<th>地点</th>
					<th>日期</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<foreach name='liveList' item='vo'>
					<tr>
						<td>{$vo.id}</td>
						<td>{$vo.name}</td>
						<td>{$vo.leaves}</td>
						<td>{$vo.rounds}</td>
						<td>{$vo.red_name}({$vo.player_red_base_num})</td>
						<td>{$vo.blue_name}({$vo.player_blue_base_num})</td>
						<td>{$vo.watcher_base_num}</td>
						<td>{$vo.money}</td>
						<td>{$vo.place}</td>
						<td>{$vo.date}</td>
						<td><a href="{:U('Live/edit', array('id'=>$vo['id']))}">编辑</a></td>
					</tr>
				</foreach>
			</tbody>
		</table>
	</div>
</body>
