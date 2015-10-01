<h1>Изменение данных профиля</h1>
<form action=<? echo "/task/user/update/" . $data["param"]; ?> method="post">
	<p>Новые данные: <input required type="text" name="update" value=<?=$data["update"]?>></p>
	<input type="submit" value="Применить">
</form>