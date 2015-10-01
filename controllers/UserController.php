<?
class UserController extends BaseController{
	public function __construct(){
		parent::__construct();
	}
	public function loginAction($data = null){
		$opt = array(	"title" 	=> "Вход",
						"content"  	=> "login.tpl");
		$this->indexAction($opt, $data);
	}
	public function registerAction($data = null){
		$opt = array(	"title" 	=> "Регистрация",
						"content"  	=> "register.tpl");
		$this->indexAction($opt, $data);
	}
	public function newAction(){
		if($_POST){
			$data = array(	"login" 	=> $_POST["userLogin"],
							"password1"	=> $_POST["userPassword1"],
							"password2"	=> $_POST["userPassword2"],
							"email" 	=> $_POST["userEmail"],
							"fname" 	=> $_POST["userFname"],
							"lname" 	=> $_POST["userLname"],
							"birthday"	=> $_POST["userBDay"],
							"phone"		=> $_POST["userPhone"],
							"captcha"	=> $_POST["captcha"]);
			$model = new UserModel();
			$result = $model->newUser($data);
			if(in_array(false, $result))
				$this->registerAction($result);
			else{
				$model->mailUser($result["email"]);
				$this->_user = &$_SESSION[md5(session_id())];
				$this->indexAction();
			}
		}
		else
			$this->registerAction();
	}
	public function authAction(){
		if($_POST){
			$data = array(	"login" 	=> $_POST["userLogin"],
							"password" 	=> $_POST["userPassword"]);
			$model = new UserModel();
			$result = $model->authUser($data);
			if($result){
				$this->_user = &$_SESSION[md5(session_id())];
				$this->indexAction();
			}
			else
				$this->loginAction();
		}
		else
			$this->loginAction();
	}
	public function profileAction(){
		$opt = array(	"title" 	=> "Личный кабинет",
						"content"	=> "profile.tpl");
		$this->indexAction($opt);
	}
	public function updateAction($param){
		if($param == null)
				$this->notFoundAction();
		$opt = array(	"title" 	=> "Изменение профиля",
						"content"  	=> ($param == 0) ? "updatefile.tpl" : "updatetext.tpl");
		$data = array();
		$data["update"]		= isset($_FILES["img"])		? $_FILES["img"]["name"] 	: null;
		if(!$data["update"])
			$data["update"]	= isset($_POST["update"])	? $_POST["update"] 			: null;
		$data["param"]		= $param;
		if($data["update"] == null){
			if($param > 6 || $param < 0)
				$this->notFoundAction();
			$this->indexAction($opt, $data);
		}
		else{
			$model = new UserModel();
			$result = $model->updateUser($data, $this->_user["id"]);
			if(in_array(false, $result))
				$this->indexAction($opt, $data);
			else
				$this->profileAction();
		}
	}
	public function deleteAction(){
		$opt = array(	"title" 	=> "Подтверждение удаления профиля",
						"content"  	=> "confirm.tpl");
		$captcha = isset($_POST["captcha"]) ? $_POST["captcha"] : null;
		if($captcha){
			$model = new UserModel();
			$result = $model->deleteUser($this->_user["id"]);
			if($result){
				unset($opt);
				$this->logoutAction();
			}
		}
		$this->indexAction($opt);
	}
	public function logoutAction(){
		session_destroy();
		header("Location: /task/");
	}
}
?>