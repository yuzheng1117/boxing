<admintpl file="header" />
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li><a href="{:U('Video/index')}">视频列表</a></li>
			<li class="active"><a href="{:U('Video/add')}">添加视频</a></li>
		</ul>
		<form action="{:U('Video/addPort')}" method="POST" novalidate="novalidate">
			<input type="hidden" name="id" value="">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>比赛名称</th>
						<td>
							<input type="text" name="name" value="">
						</td>
					</tr>
					<tr>
						<th>视频封面链接</th>
						<td>
							<input type="text" name="image" value="">
						</td>
					</tr>
					<tr>
						<th>级别</th>
						<td>
							<input type="text" name="nick_name" value="">
						</td>
					</tr>
					<tr>
						<th>回合数</th>
						<td>
							<input type="text" name="birth" value="">
						</td>
					</tr>
					<tr>
						<th>红方选手</th>
						<td>
							<select name="player_red_id">
								<option value="">==请选择==</option>
								<foreach name='players' item='vo'>
									<option value="{$vo.id}">{$vo.name}</option>
								</foreach>
							</select>
						</td>
					</tr>
					<tr>
						<th>蓝方选手</th>
						<td>
							<select name="players_blue_id">
								<option value="">==请选择==</option>
								<foreach name='players' item='vo'>
									<option value="{$vo.id}">{$vo.name}</option>
								</foreach>
							</select>
						</td>
					</tr>
					<tr>
						<th>胜利者</th>
						<td>
							<select name="winner">
								<option value="">==请选择==</option>
								<option value="1">红方胜利</option>
								<option value="2">蓝方胜利</option>
								<option value="0">平局</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<input class="btn btn-primary" type="submit" value="提交">
		</form>
	</div>
</body>
