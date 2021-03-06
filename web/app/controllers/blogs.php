<?php
	requirePHPLib('form');

	if (!isUser($myUser)) {
		become403Page();
	}
	
	function echoBlogCell($blog) {
		echo '<tr>';
		if ($blog['is_hidden']) {
			echo '<td><span class="text-danger">[已隐藏]</span>' . getBlogLink($blog['id']) . '</td>';
		} else {
			echo '<td>' . getBlogLink($blog['id']) . '</td>';
		}
		echo '<td>' . getUserLink($blog['poster']) . '</td>';
		echo '<td>' . $blog['post_time'] . '</td>';
		echo '</tr>';
	}
	$header = <<<EOD
	<tr>
		<th width="60%">标题</th>
		<th width="20%">发表者</th>
		<th width="20%">发表日期</th>
	</tr>
EOD;
	$config = array();
	$config['table_classes'] = array('table', 'table-hover');
?>
<?php echoUOJPageHeader(UOJLocale::get('blogs')) ?>
<?php if (Auth::check()): ?>
<div class="float-right">
	<div class="btn-group">
		<a href="<?= HTML::blog_url(Auth::id(), '/') ?>" class="btn btn-secondary btn-sm">我的博客首页</a>
		<a href="<?= HTML::blog_url(Auth::id(), '/post/new/write')?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> 写新博客</a>
	</div>
</div>
<?php endif ?>
<h3>博客总览</h3>
<?php echoLongTable(array('id', 'poster', 'title', 'post_time', 'zan', 'is_hidden'), 'blogs', "is_hidden = 0 or poster = '{$myUser['username']}'", 'order by post_time desc', $header, 'echoBlogCell', $config); ?>
<?php echoUOJPageFooter() ?>
