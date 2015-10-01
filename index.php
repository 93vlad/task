<?
ini_set("display_errors", "on");
set_include_path(get_include_path() 	. PATH_SEPARATOR . "core/"
										. PATH_SEPARATOR . "controllers/"
										. PATH_SEPARATOR . "template/"
										. PATH_SEPARATOR . "template/layout/"
										. PATH_SEPARATOR . "models/"
										. PATH_SEPARATOR . "errors/");
function __autoload($class){
	include_once($class . ".php");
}
session_start();
$app = new Application();
$app->run();
?>