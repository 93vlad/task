<h1>Шапка</h1>
<a href="/task">Главная</a>
<a href="/task/contact/">Контакты</a>
<?
if(isset($user)){
	$name	= $user["fname"] . " " . substr($user["lname"], 0, 1) . ".";
?>	
	<a href="/task/user/profile/">Личный кабинет</a>
	<a href="/task/user/logout/">Выход</a>
	<div class="user"><?=$name?><img src=<?="/task/template/images/icon.php"?>></div>
<?
}
else
	echo '<a href="/task/user/login/">Вход</a>';
?>