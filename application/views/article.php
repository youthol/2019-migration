<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>网站迁移</title>
	<style type="text/css">
	</style>
</head>
<body>

<div id="container">
	<h1>
		<?= $info['title']; ?>
	</h1>
	<span id="time">发布时间：<?= $info['time']; ?></span>
	<span id="copyfrom">来源：<?= $info['copyFrom']; ?></span>
	<span id="author">作者：<?= $info['author']; ?></span>
	<p id="content">
		<?= $info['content']; ?>
		<span style="float: right; padding: 50px 50px 50px 0;">责编：<?= $info['editor']; ?></span>
	</p>
</div>

</body>
</html>
