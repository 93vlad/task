<!DOCTYPE html>
<html>
<head>
	<title><?=$opt["title"]?></title>
	<link type="text/css" href="/task/template/style/style.css" rel="stylesheet">
</head>
<body>
	<div class="head">
		<? include_once($opt["header"]) ?>
	</div>
	<div class="content">
		<? include_once($opt["content"]) ?>
	</div>
	<div class="footer">
		<? include_once($opt["footer"]) ?>
	</div>
</body>
</html>