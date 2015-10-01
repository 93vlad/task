<h1>Регистрация</h1>
<form action="/task/user/new/" method="post">
<p>Ваше имя: <input required type="text" name="userFname" value=<?=$data["fname"]?>></p>
<p>Ваша фамилия: <input required type="text" name="userLname" value=<?=$data["lname"]?>></p>
<p>Ваш логин: <input required type="text" name="userLogin" value=<?=$data["login"]?>></p>
<p>Ваш пароль: <input required type="password" name="userPassword1"></p>
<p>Повторите пароль: <input required type="password" name="userPassword2"></p>
<p>Ваш e-mail: <input required type="text" name="userEmail" value=<?=$data["email"]?>></p>
<p>Дата рождения: <input required type="text" name="userBDay" value=<?=$data["birthday"]?>></p>
<p>Мобильный телфон: <input required type="text" name="userPhone" value=<?=$data["phone"]?>></p>
<img src="/task/template/images/captcha.php">
<p>Введите текст с картинки: <input required type="text" name="captcha"></p>
<input type="submit" value="Регистрация">
</form>