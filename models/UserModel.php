<?
class UserModel extends BaseModel{
	public function newUser($data){
		if(	$data["password1"] 	 == $data["password2"] &&
			$_SESSION["captcha"] == strtoupper($data["captcha"])){
				unset($data["password2"], $data["captcha"], $_SESSION["captcha"]);
				$data["login"] 		= $this->validData($data["login"], 		"ul");
				$data["password1"]	= $this->validData($data["password1"],	"up");
				$data["email"] 		= $this->validData($data["email"], 		"ue");
				$data["fname"] 		= $this->validData($data["fname"], 		"un");
				$data["lname"] 		= $this->validData($data["lname"], 		"un");
				$data["birthday"]	= $this->validData($data["birthday"],	"dt");
				$data["phone"] 		= $this->validData($data["phone"], 		"ph");
		}
		else{
			$data["password1"] 	= false;
			$data["captcha"] 	= false;
			return $data;
		}
		if(!in_array(false, $data)){
			$this->_dbc = $this->dbConnect();
			$result = $this->selectData($this->_dbc, $data["login"], "login", array("id"));
			if($result){
				$data["login"] = false;
				return $data;
			}
			$this->insertData($this->_dbc, $data);
			$data["id"] 	= $this->_dbc->lastInsertId();
			$data["img"] 	= null;
			$this->userToSession($data);
			unset($data["img"]);
			return $data;
		}
		else{
			return $data;
		}
	}
	public function mailUser($email){
		$to 		= $email;
		$subject 	= "Subject";
		$message 	= "Some text...";
		$headers 	= "From: example_adress@com";
		mail($to, $subject, $message, $headers);
	}
	public function authUser($data){
		$data["login"] 		= $this->validData($data["login"], 		"ul");
		$data["password"]	= $this->validData($data["password"],	"up");
		if(!in_array(false, $data)){
			$this->_dbc = $this->dbConnect();
			$result = $this->selectData($this->_dbc, $data["login"], "login", array("id",
																					"login",
																					"password",
																					"email",
																					"fname",
																					"lname",
																					"birthday",
																					"phone",
																					"img"));
			if(	$data["login"] 		=== $result["login"] &&
				$data["password"]	=== $result["password"]){
				$this->userToSession($result);
				return true;
			}
			else
				return false;
		}
		else
			return false;
	}
	public function userToSession($data){
		$_SESSION[md5($_COOKIE[session_name()])] = array(	"id"		=> $data["id"],
															"login" 	=> $data["login"],
															"email" 	=> $data["email"],
															"fname" 	=> $data["fname"],
															"lname" 	=> $data["lname"],
															"birthday"	=> $data["birthday"],
															"phone" 	=> $data["phone"],
															"img"		=> $data["img"]);
	}
	public function updateUser($data, $id){
		$field = null;
		$type = null;
		switch($data["param"]){
			case "0":
				$field = "img";
				$type = "im";
				break;
			case "1":
				$field = "fname";
				$type = "un";
				break;
			case "2":
				$field = "lname";
				$type = "un";
				break;
			case "3":
				$field = "login";
				$type = "ul";
				break;
			case "4":
				$field = "email";
				$type = "ue";
				break;
			case "5":
				$field = "birthday";
				$type = "dt";
				break;
			case "6":
				$field = "phone";
				$type = "ph";
				break;
		}
		$data["update"] = $this->validData($data["update"], $type);
		if(!$data["update"])
			return $data;
		if($type == "im"){
			$filename = $_SERVER["DOCUMENT_ROOT"] . 'task/template/images/user_images/' . "$id.jpg";
			$data["update"] = "$id.jpg";
			move_uploaded_file($_FILES["img"]["tmp_name"], $filename);
			$data["param"] = true;
		}
		$this->_dbc = $this->dbConnect();
		$result = $this->updateData($this->_dbc, $data["update"], $field, $id);
		if($result){
			$_SESSION[md5(session_id())][$field] = $data["update"];
			return $data;
		}
		else{
			$data["result"] = false;
			return $data;
		}				
	}
	public function deleteUser($id){
		$this->_dbc = $this->dbConnect();
		$result = $this->deleteData($this->_dbc, $id);
		if($result == 0)
			return false;
		else{
			$filename = $_SERVER["DOCUMENT_ROOT"] . 'task/template/images/user_images/' . "$id.jpg";
			unlink($filename);
			return true;
		}
	}
}
?>