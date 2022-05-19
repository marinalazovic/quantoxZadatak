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

    $params= parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $paramsArray= array();
    parse_str($params, $paramsArray);

    $limit = $paramsArray["limit"] ? $paramsArray["limit"] : null;
    $page = $paramsArray["page"] ? $paramsArray["page"] : null;

    $sort = $paramsArray["sort"] ? $paramsArray["sort"] : null;
    $order = $paramsArray["order"] ? $paramsArray["order"] : null;


    if($uri[1]!== API_ROUTE_COMPONENT)
        notFound();
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $id=null;

    if(isset($uri[3]) && is_numeric($uri[3]))
        $id=intval($uri[3]);

    switch ($uri[2]) {
        case GROUP_ROUTE_COMPONENT:
            headers();
            execGroupController($requestMethod,$id,$sort,$order,$limit, $page);
            break;
        case INTERN_ROUTE_COMPONENT:
            headers();
            execInternController($requestMethod,$id,$sort,$order,$limit, $page);
            break;
        case MENTOR_ROUTE_COMPONENT:
            headers();
            execMentorController($requestMethod,$id,$sort,$order,$limit, $page);
            break;
        default:
            notFound();
    }
}

function execGroupController($requestMethod, ?int $id,$sort,$order, $limit, $page)
{
    $db= new \PhpApi\Db\Database();
    $controller= new \PhpApi\Api\GroupController($db->getConnection());
    $controller->exec($requestMethod, $id,$sort,$order, $limit, $page);
}

function execInternController($requestMethod, ?int $id ,$sort,$order, $limit, $page)
{
    $db= new \PhpApi\Db\Database();
    $controller= new \PhpApi\Api\InternController($db->getConnection());
    $controller->exec($requestMethod, $id, $sort,$order,$limit, $page);
}

function execMentorController($requestMethod, ?int $id,$sort,$order,$limit, $page)
{
    $db= new \PhpApi\Db\Database();
    $controller= new \PhpApi\Api\MentorController($db->getConnection());
    $controller->exec($requestMethod, $id,$sort,$order,$limit, $page);

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

