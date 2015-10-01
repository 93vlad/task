<?
class BaseController{
	protected $_view, $_model;
	protected $_user = null;

	public function __construct(){
		if(isset($_SESSION[md5(session_id())]))
			$this->_user = &$_SESSION[md5(session_id())];
		$this->_model = new BaseModel();
		$this->_view = new BaseView();
	}
	public function indexAction($opt = null, $data = null){
		if($this->_user && !$opt)
			$opt = array(	"title" 	=> "Главная",
							"content"	=> "usermain.tpl");
		$opt = $this->_view->getOptions($opt);
		$this->_view->generatePage($opt, $data, $this->_user);
	}
	public function contactAction(){
		$opt = array(	"title"		=> "Контакты",
						"content"	=> "contact.tpl");
		$this->indexAction($opt);
	}
	public function notFoundAction(){
		$opt = array(	"title" 	=> "Страница не найдена",
						"content"	=> "error404.tpl");
		$this->indexAction($opt);
	}
}
?>