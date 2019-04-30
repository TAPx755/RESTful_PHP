<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-02-21
 * Time: 17:33
 */

require_once "Database.php";

interface DatabaseObject
{
    public function create();
    public static function get($id);
    public function getAll();
    public static function delete($id);
    public function update();
}