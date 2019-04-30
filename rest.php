<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-02-07
 * Time: 13:52
 */

require_once 'controllers/ActivityPackRESTController.php';

// http://localhost/K1Passwordmanager2.0ANGABE/index.php?r=credentials/view$id=25

try
{
    (new ActivityPackRESTController())->handleRequest();
}
catch(Exception $e)
{
    header('HTTP/1.1 400'. $e->getMessage());
    echo json_encode($e->getMessage());
}
?>