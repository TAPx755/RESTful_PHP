<?php
session_start();
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-02-07
 * Time: 13:52
 */

require_once 'controllers/ActivityPackRESTController.php';
require_once 'controllers/UserRESTController.php';
require_once 'controllers/AccessRESTController.php';

// http://localhost/K1Passwordmanager2.0ANGABE/index.php?r=credentials/view$id=25

/*echo password_hash("hallo123", PASSWORD_BCRYPT);
echo "result:";
echo password_verify("hallo123", '$2y$10$ZEzf0r1qbWOi8bK7kTbPluCo20z4FfSY/UHn0m5GWi9wdJZaX3H5a');*/

    $controller = $_GET['r'];
    if(!strpos($controller, "/") === FALSE)
    {
        $controller = substr($controller, 0, strpos($controller,"/"));
    }
if($controller == 'user')
{
    try
    {
        (new UserRESTController())->handleRequest();
    }
    catch(Exception $e)
    {
        header('HTTP/1.1 400'. $e->getMessage());
        echo json_encode($e->getMessage());
    }
}
else if($controller == 'activitypackage')
{
    try
    {
        (new ActivityPackRESTController())->handleRequest();
    }
    catch(Exception $e)
    {
        header('HTTP/1.1 400'. $e->getMessage());
        echo json_encode($e->getMessage());
    }
}
else if($controller == 'access') {
    try {
        (new AccessRESTController())->handleRequest();
    } catch (Exception $e) {
        header('HTTP/1.1 400' . $e->getMessage());
        echo json_encode($e->getMessage());
    }
}
else
{
    throw new Exception('Invalid request');
}



?>