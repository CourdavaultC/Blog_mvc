<?php
require_once 'views/View.php';
/**
 * 
 */
class Router
{
    private $ctrl;
    private $view;

    public function routeReq(){

        try {
            // autoload of classes from models's folder
            spl_autoload_register(function($class){
                require_once('models/'.$class.'.php');
            });

            // Creation of the variable $url.
            $url = '';

            // We gonna determinate the Controller with the value of $url.
            if (isset($_GET['url'])) {
                // We decompose the url, and we add e filter on it.
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

                // Wet get the first parameter of the url.
                $controller = ucfirst(strtolower($url[0]));

                $controllerClass = "Controller".$controller;

                // We found the needing controller.
                $controllerFile = "controllers/".$controllerClass.".php";

                // On check if the folder of the controller exist
                if(file_exists($controllerFile)) {
                    // We launch the needing class with all the url parameters and respect the encpsulation.
                    require_once($controllerFile);
                    $this->ctrl = new $controllerClass($url);
                } else {
                    throw new \Exception("Page introuvable", 1);
                }
            } else {
                require_once('controllers/ControllerAccueil.php');
                $this->ctrl = new ControllerAccueil($url);
            }

        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            $this->_view = new View('Error');
            $this->_view->generate(array('errorMsg' => $errorMsg));
            
        }
    }
}
?>