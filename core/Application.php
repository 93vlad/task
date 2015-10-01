<?
class Application{
	public function run(){
		$reqData = Route::unbuildURL();
		ob_start();
		header("Content-type: text/html; charset=utf-8");
		$this->execute($reqData);
		echo ob_get_clean();
	}
	private function execute(array $reqData){
		if(class_exists($reqData["controller"])){
			$rc = new ReflectionClass($reqData["controller"]);
			if($rc->hasMethod($reqData["action"])){
				$controller = $rc->newInstance();
				$action = $rc->getMethod($reqData["action"]);
				$action->invoke($controller, $reqData["param"]);
			}
			else{
				$reqData = array(	"controller" 	=> "BaseController",
									"action"		=> "notFoundAction",
									"param"			=> null);
				$this->execute($reqData);
			}
		}
		else{
			$reqData = array(	"controller" 	=> "BaseController",
								"action"		=> "notFoundAction",
								"param"			=> null);
			$this->execute($reqData);
		}
	}
}
?>