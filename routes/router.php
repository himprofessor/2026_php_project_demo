<?php
require_once("routes.php");
$URI = parse_url($_SERVER["REQUEST_URI"])["path"];
if(array_key_exists($URI, $routes)){
    require_once($routes[$URI]);
}else{
    require_once($routes["/home"]);
}