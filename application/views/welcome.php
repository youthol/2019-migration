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
	<ul>
		<?php foreach ($result as $value): ?>
			<li>
				<a
					href="http://localhost/2019-migration/index.php/article?id=<?= $value->id; ?>"
				>
					<?= $value->title; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<div id="page">
		<?php for ($i = 1; $i <= $pageNum; ++$i) : ?>
			<a href="http://localhost/2019-migration/index.php/list?catId=<?= $catId ?>&page=<?= $i ?>">
				<?= $i ?>
			</a>
		<?php endfor; ?>
	</div>
</div>

</body>
</html>
