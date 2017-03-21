<admintpl file="header" />
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="{:U('Video/index')}">视频列表</a></li>
			<li><a href="{:U('Video/add')}">添加视频</a></li>
		</ul>
		<form action="{:U('Video/editPort')}" method="POST" novalidate="novalidate">
			<input type="hidden" name="id" value="">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>id</th>
						<td>
							{$data.id}
							<input type="hidden" name="id" value="{$data.id}">
						</td>
					</tr>
					<tr>
						<th>比赛名称</th>
						<td>
							<input type="text" name="name" value="{$data.name}">
						</td>
					</tr>
					<tr>
						<th>比赛图片</th>
						<td><input type="text" name="image" value="{$data.image}"></td>
					</tr>
					<tr>
						<th>级别</th>
						<td>
							<input type="text" name="leaves" value="{$data.leaves}">
						</td>
					</tr>
					<tr>
						<th>回合数</th>
						<td>
							<input type="text" name="rounds" value="{$data.rounds}">
						</td>
					</tr>
					<tr>
						<th>红方选手</th>
						<td>
							<select name="player_red_id">
								<option value="">==请选择==</option>
								<foreach name='players' item='vo'>
									<option value="{$vo.id}" {$vo['id']==$data['player_red_id']?'selected':null}>{$vo.name}</option>
								</foreach>
							</select>
						</td>
					</tr>
					<tr>
						<th>蓝方选手</th>
						<td>
							<select name="player_blue_id">
								<option value="">==请选择==</option>
								<foreach name='players' item='vo'>
									<option value="{$vo.id}" {$vo['id']==$data['player_blue_id']?'selected':null}>{$vo.name}</option>
								</foreach>
							</select>
						</td>
					</tr>
					<tr>
						<th>胜利者</th>
						<td>
							<select name="winner">
								<option value="">==请选择==</option>
								<option value="1" {$data['winner']=='1'?'selected':null}>红方胜利</option>
								<option value="2" {$data['winner']=='2'?'selected':null}>蓝方胜利</option>
								<option value="0" {$data['winner']=='3'?'selected':null}>平局</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>视频链接</th>
						<td><input type="text" name="link" value="{$data['link']}"></td>
					</tr>
				</tbody>
			</table>
			<input class="btn btn-primary" type="submit" value="提交">
		</form>
	</div>
</body>
