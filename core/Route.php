<?
class Route{
	public static function unbuildURL(){
		$request = $_SERVER["REQUEST_URI"];
		preg_match('/^\/task\/([A-Za-z]+)?\/?([A-Za-z]+)?+\/?([0-9]+)?$/', $request, $url);
		$controller	= 	!(empty($url[1]) || count($url) == 2) ?
						ucfirst(strtolower($url[1])) . "Controller" :
						"BaseController";
		if(!empty($url[2]))
			$action = strtolower($url[2]) . "Action";
		elseif(count($url) == 2)
			$action = strtolower($url[1]) . "Action";
		else
			$action = "indexAction";
		$param	= isset($url[3]) ? (string)$url[3] : null;
		return [	"controller" 	=> $controller,
					"action" 		=> $action,
					"param" 		=> $param];
	}
}
?>