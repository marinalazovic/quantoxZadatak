<?php
include_once 'src/bootstrap.php';

const API_ROUTE_COMPONENT = "api";
const GROUP_ROUTE_COMPONENT = "group";
const INTERN_ROUTE_COMPONENT = "intern";
const MENTOR_ROUTE_COMPONENT = "mentor";

execController();

function execController()
{
    $uri= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri =explode('/', $uri);
    if($uri[1]!== API_ROUTE_COMPONENT)
        notFound();
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $id=null;

    if(isset($uri[3]) && is_numeric($uri[3]))
        $id=intval($uri[3]);

    switch ($uri[2]) {
        case GROUP_ROUTE_COMPONENT:
            headers();
            execGroupController($requestMethod,$id);
            break;
        case INTERN_ROUTE_COMPONENT:
            headers();
            execInternController($requestMethod,$id);
            break;
        case MENTOR_ROUTE_COMPONENT:
            headers();
            execMentorController($requestMethod,$id);
            break;
        default:
            notFound();
    }
}

function execGroupController($requestMethod, ?int $id)
{
    $db= new \PhpApi\Db\Database();
    $controller= new \PhpApi\Api\GroupController($db->getConnection());
    $controller->exec($requestMethod, $id);
}

function execInternController($requestMethod, ?int $id)
{
    $db= new \PhpApi\Db\Database();
    $controller= new \PhpApi\Api\InternController($db->getConnection());
    $controller->exec($requestMethod, $id);
}

function execMentorController($requestMethod, ?int $id)
{
    $db= new \PhpApi\Db\Database();
    $controller= new \PhpApi\Api\MentorController($db->getConnection());
    $controller->exec($requestMethod, $id);

}


function headers()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

function notFound()
{
    header("HTTP/1.1 404 Not Found");
    exit();
}

