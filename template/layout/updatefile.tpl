<h1>Изменение картнки</h1>
<form enctype="multipart/form-data" action="/task/user/update/0" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value=<?=(1024*1024)?>/>
	<p>Выберите изображение формата "JPG", не более 1 МБ: <input type="file" name="img" accept="image/jpeg"></p>
	<input type="submit" value="Применить">
</form>