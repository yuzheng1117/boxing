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
			<li class="active"><a href="{:U('Players/index')}">运动员列表</a></li>
			<li><a href="{:U('Players/add')}">增加运动员</a></li>
		</ul>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>id</th>
					<th>姓名</th>
					<th>绰号</th>
					<th>年龄</th>
					<th>籍贯</th>
					<th>身高</th>
					<th>体重</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<foreach name='players' item='vo'>
					<tr>
						<td>{$vo.id}</td>
						<td>{$vo.name}</td>
						<td>{$vo.nick_name}</td>
						<td>{$vo.age}</td>
						<td>{$vo.place}</td>
						<td>{$vo.height}</td>
						<td>{$vo.weight}</td>
						<td><a href="{:U('Players/edit', array('id'=>$vo['id']))}">操作</a></td>
					</tr>
				</foreach>
			</tbody>
		</table>
	</div>
</body>
