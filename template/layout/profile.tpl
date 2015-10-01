<h1>Личный кабинет</h1>
<img src=
<?
if (isset($user["img"]))
	echo "/task/template/images/user_images/" . $user["img"];
else
	echo "/task/template/images/user.jpg";
?>
>
<a href="/task/user/update/0">Изменить картинку</a>
<p>Имя: <?=$user["fname"]?> | <a href="/task/user/update/1">Изменить</a></p>
<p>Фамилия: <?=$user["lname"]?> | <a href="/task/user/update/2">Изменить</a></p>
<p>Логин: <?=$user["login"]?> | <a href="/task/user/update/3">Изменить</a></p>
<p>Почта: <?=$user["email"]?> | <a href="/task/user/update/4">Изменить</a></p>
<p>Дата рождения: <?=$user["birthday"]?> | <a href="/task/user/update/5">Изменить</a></p>
<p>Телефон: <?=$user["phone"]?> | <a href="/task/user/update/6">Изменить</a></p>
<p><a href="/task/user/delete/">Удалить профиль</a></p>