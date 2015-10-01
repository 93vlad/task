<?
class BaseModel{
	protected $_dbc;
	public function __construct(){}
	public function validData($data, $type = ""){
		switch($type){
			case "ul"://user-login проверка логина
				preg_match('/[A-Za-z0-9\)\(_\-]{4,30}/u', $data, $arr);
				return strlen($data) == strlen($arr[0]) ? $arr[0] : false;
				break;
			case "un"://user-name проверка имени, фамилии
				preg_match('/[А-Яа-яA-Za-z0-9\)\(_\-]{2,30}/u', $data, $arr);
				return strlen($data) == strlen($arr[0]) ? $arr[0] : false;
				break;
			case "up"://user-password проверка пароля
				preg_match('/[\w]{6,16}/u', $data, $arr);
				return strlen($data) == strlen($arr[0]) ? md5($arr[0]) : false;
				break;
			case "ue"://user-email проверка имени почтового ящика
				preg_match('/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/', $data, $arr);
				if(isset($arr[0])){
					return strlen($data) == strlen($arr[0]) ? $arr[0] : false;
				}
				return false;
				break;
			case "dt"://date проверка даты
				preg_match('/(\d{4})\.(\d{1,2})\.(\d{1,2})/', $data, $arr);
				return checkdate($arr[2], $arr[3], $arr[1]) ? $arr[0] : false;
				break;
			case "ph"://phone проверка номера телефона
				preg_match('/\d{3}-\d{7}/', $data, $arr);
				return !empty($arr) ? $arr[0] : false;
				break;
			case "im"://image проверка имени и расширения картинки
				preg_match('/[А-Яа-яA-Za-z0-9\)\(_\-]{1,20}.[jpg|jpeg]/', $data, $arr);
				if($_FILES["img"]["size"] > (1024*1024)){
					return false;
					break;
				}
				return !empty($arr) ? $arr[0] : false;
				break;
			default:
				return false;
				break;
		}
	}
	public function dbConnect(){
		$dbengine	= "mysql";
		$dbhost		= "localhost";
		$dbname		= "task";
		$dbcharset	= "utf8";
		$dbuser 	= "root";
		$dbpassword = null;
		$opt = array(	PDO::ATTR_ERRMODE				=> PDO::ERRMODE_WARNING,
						PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC);
		$dsn = "$dbengine:host=$dbhost;dbname=$dbname;charset=$dbcharset;";
		try{
			$this->_dbc = new PDO($dsn, $dbuser, $dbpassword, $opt);
			return $this->_dbc;
			}
		catch(PDOException $e){
			echo "Произошла ошибка. Приносим извинения.<br><a href='/task/'>Главная</a>";
			file_put_contents(	"error.log",
								"Ошибка при подключении к базе данных.\n" . 
								"Ошибка: " . $e->getMessage() . 
								"\nФайл: " . $e->getFile() . 
								"\nСтрока: " . $e->getLine() . "\n\n", 
								FILE_APPEND | FILE_USE_INCLUDE_PATH);
		}
	}
	public function insertData($dbc, $data){
		$data = array_values($data);
		list(	$login,
				$password,
				$email,
				$fname,
				$lname,
				$bday,
				$phone) = $data;
		$stmt = $dbc->prepare("INSERT INTO users 
												(	login,
													password,
													email,
													fname,
													lname,
													birthday,
													phone)
										   	VALUES
										   		(	:login,
										   			:password,
										   			:email,
													:fname,
													:lname,
													:birthday,
													:phone);");
		$stmt->bindValue(":login", 		$login);
		$stmt->bindValue(":password",	$password);
		$stmt->bindValue(":email", 		$email);
		$stmt->bindValue(":fname", 		$fname);
		$stmt->bindValue(":lname", 		$lname);
		$stmt->bindValue(":birthday", 	$bday);
		$stmt->bindValue(":phone", 		$phone);
		$stmt->execute();
	}
	public function selectData($dbc, $data, $condition, $field){
		$sql = "SELECT ";
		$i = 1;
		$count = count($field);
		foreach($field as $value){
			if($i == $count)
				break;
			$sql .= "$value, ";
			$i++;
		}
		$sql .= array_pop($field) . " FROM users";
		$sql .= " WHERE $condition=?";
		$stmt = $dbc->prepare($sql);
		$arr[] = $data;
		$stmt->execute($arr);
		$result = $stmt->fetch();
		return $result;
	}
	public function updateData($dbc, $data, $field, $id){
		$sql = "UPDATE users SET $field='" . $data . "' WHERE id=?";
		$stmt = $dbc->prepare($sql);
		$arr[] = $id;
		$result = $stmt->execute($arr);
		return $result;
	}
	public function deleteData($dbc, $id){
		$sql = "DELETE FROM users WHERE id=$id";
		$result = $dbc->exec($sql);
		return $result;
	}
}
?>