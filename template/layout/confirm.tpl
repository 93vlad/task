<h1>Удалить профиль?</h1>
<form action="/task/user/delete/" method="post">
	<p>Для подтверждение введите текст с картинки:</p>
	<img src="/task/template/images/captcha.php">
	<input required type="text" name="captcha">
	<input type="submit" value="Подтвердить">
</form>