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
			<li class="active"><a href="{:U('Video/index')}">视频列表</a></li>
			<li><a href="{:U('Video/add')}">增加视频</a></li>
		</ul>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>比赛id</th>
					<th>视频名称</th>
					<th>级别</th>
					<th>回合数</th>
					<th>红方选手</th>
					<th>蓝方选手</th>
					<th>胜利者</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<foreach name='videoList' item='vo'>
					<tr>
						<td>{$vo.id}</td>
						<td>{$vo.name}</td>
						<td>{$vo.leaves}</td>
						<td>{$vo.rounds}</td>
						<td>{$vo.red_name}</td>
						<td>{$vo.blue_name}</td>
						<td>{$vo.winner_name}</td>
						<td><a href="{:U('Video/edit', array('id'=>$vo['id']))}">操作</a></td>
					</tr>
				</foreach>
			</tbody>
		</table>
	</div>
</body>
