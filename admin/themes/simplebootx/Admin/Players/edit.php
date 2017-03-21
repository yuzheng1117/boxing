<admintpl file="header" />
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="{:U('Players/index')}">运动员列表</a></li>
			<li><a href="{:U('Players/add')}">增加运动员</a></li>
		</ul>
		<form action="{:U('Players/editPort')}" method="POST" novalidate="novalidate">
			<input type="hidden" name="id" value="{$data.id'}">
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
						<th>姓名</th>
						<td>
							<input type="text" name="name" value="{$data.name}">
						</td>
					</tr>
					<tr>
						<th>绰号</th>
						<td>
							<input type="text" name="nick_name" value="{$data.nick_name}">
						</td>
					</tr>
					<tr>
						<th>出生年份</th>
						<td>
							<input type="text" name="birth" value="{$data.birth}">
						</td>
					</tr>
					<tr>
						<th>籍贯</th>
						<td>
							<input type="text" name="place" value="{$data.place}">
						</td>
					</tr>
					<tr>
						<th>身高</th>
						<td>
							<input type="text" name="height" value="{$data.height}">
						</td>
					</tr>
					<tr>
						<th>体重</th>
						<td>
							<input type="text" name="weight" value="{$data.weight}">
						</td>
					</tr>
				</tbody>
			</table>
			<input class="btn btn-primary" type="submit" value="提交">
		</form>
	</div>
</body>
