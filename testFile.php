<?php
require "models/ActivityPackage.php";

//include "models/Database.php";
include "auth/JWTToken.php";

echo '<h1>Testfile run</h1>';
//require_once 'models/AccessMerge.php';
//$user = new AccessMerge();
//$user->handleUserRequest(2);
//print_r($user->jsonSerialize());
//echo "<br>";
//$user->handleAktivitypackageRequest(1);
//print_r($user->jsonSerialize());
//die();

    /*$token = array(
        "username" => 'pat@tsn.at',
        "password" => 'hallo123',
        "id" => '11',
        "privilege" => 'Admin'
    );
    $generatedToken = JWTToken::generateToken($token);


    $db = Database::connect();
    $sql = 'INSERT INTO tbl_User (u_Name, u_Password, u_Token, u_Email, u_Privilege) values (?,?,?,?,?)';
    $stmt = $db->prepare($sql);
    $stmt->execute(array("Pat", "hallo123", $generatedToken, "pat@tsn.at", 'Admin'));
    //return $db->lastInsertId();
    Database::disconnect();*/

/*$_GET['r'] = "skkir/sxas/";

$lol = isset($_GET['r']) ? explode('/', trim($_GET['r'], '/')) : [];
if (sizeof($lol) == 0) {
    throw new Exception('Invalid request');
}
print_r($lol);*/
//$jwtToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VybmFtZSI6InBhdEB0c24uYXQiLCJwYXNzd29yZCI6ImhhbGxvMTIzIiwiaWQiOiIxMSIsInByaXZpbGVnZSI6IkFkbWluIn0.gDZLETpeQj7fCaLp0sBPCZrKVq9s4ti2uxb_cVyi3XeJQnsQJIAhXoCLbDZWe_ncJwjGEFo4YRYCkUZpGnI8ZF5jhkSsbosINEcI44G7J-qICgrl_O0YX5zF9JFVBcOQ5jbJJbdLjcn92T-Nc4OcMjPzpbQWch8XEXTi3TJCdPqypgUoCTSd0sy6z3bAp4kk7fiIExplcWidb73pbFFwIPggK_EYOpDygE5J7zxbZhuyarST-M8HR24no9q3H_vDZFWr4XJffZoa1DniHhfX44kpnyfA45i8ruDdKaxWS9NOA67eGHheTYT8kGopIapWAjw45cTpsMp1Zz-p3Ppm6w';

    //echo JWTToken::validateToken($jwtToken);
    //print_r(JWTToken::parseToken($jwtToken)->id);



$db = Database::connect();
$sql = 'SELECT u_Token FROM tbl_User WHERE u_ID = ?';
$stmt = $db->prepare($sql);
$stmt->execute(array(16));
$tokenFromDB = $stmt->fetch(PDO::FETCH_ASSOC);
$token = $tokenFromDB['u_Token'];
Database::disconnect();

echo "Token1: " . $token;

echo "";

echo "Token2:" . "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VybmFtZSI6InBhdEB0c24uYXQiLCJwYXNzd29yZCI6ImhhbGxvMTIzIiwiaWQiOiIxMSIsInByaXZpbGVnZSI6IkFkbWluIn0.gDZLETpeQj7fCaLp0sBPCZrKVq9s4ti2uxb_cVyi3XeJQnsQJIAhXoCLbDZWe_ncJwjGEFo4YRYCkUZpGnI8ZF5jhkSsbosINEcI44G7J-qICgrl_O0YX5zF9JFVBcOQ5jbJJbdLjcn92T-Nc4OcMjPzpbQWch8XEXTi3TJCdPqypgUoCTSd0sy6z3bAp4kk7fiIExplcWidb73pbFFwIPggK_EYOpDygE5J7zxbZhuyarST-M8HR24no9q3H_vDZFWr4XJffZoa1DniHhfX44kpnyfA45i8ruDdKaxWS9NOA67eGHheTYT8kGopIapWAjw45cTpsMp1Zz-p3Ppm6w";

echo "ERG: " . strcmp($token, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VybmFtZSI6InBhdEB0c24uYXQiLCJwYXNzd29yZCI6ImhhbGxvMTIzIiwiaWQiOiIxMSIsInByaXZpbGVnZSI6IkFkbWluIn0.gDZLETpeQj7fCaLp0sBPCZrKVq9s4ti2uxb_cVyi3XeJQnsQJIAhXoCLbDZWe_ncJwjGEFo4YRYCkUZpGnI8ZF5jhkSsbosINEcI44G7J-qICgrl_O0YX5zF9JFVBcOQ5jbJJbdLjcn92T-Nc4OcMjPzpbQWch8XEXTi3TJCdPqypgUoCTSd0sy6z3bAp4kk7fiIExplcWidb73pbFFwIPggK_EYOpDygE5J7zxbZhuyarST-M8HR24no9q3H_vDZFWr4XJffZoa1DniHhfX44kpnyfA45i8ruDdKaxWS9NOA67eGHheTYT8kGopIapWAjw45cTpsMp1Zz-p3Ppm6w');