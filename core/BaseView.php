<?
class BaseView{
	public function __construct(){}
	public function getOptions($opt){
		$arr = array();
		$arr["title"] 	= isset($opt["title"]) 		? $opt["title"] 	: "Главная";
		$arr["content"] = isset($opt["content"])	? $opt["content"]	: "main.tpl";
		$arr["header"]  = isset($opt["header"]) 	? $opt["header"]  	: "header.tpl";
		$arr["footer"]  = isset($opt["footer"])  	? $opt["footer"]  	: "footer.tpl";
		return $arr;
	}
	public function generatePage($opt, $data = null, $user){
		include_once "template/index.php";
	}
}
?>