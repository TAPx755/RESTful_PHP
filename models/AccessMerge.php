<?php
/**
 * Created by PhpStorm.
 * User: vivi_mac
 * Date: 2019-06-01
 * Time: 22:06
 */

require_once "models/UserAccess.php";
require_once "models/AccessModel.php";
require_once "models/User.php";

class AccessMerge implements JsonSerializable
{
    private $ap_id;
    private $access;
    private $useraccess;
    private $users;

    /**
     * AccessController constructor.
     * @param $ap_id
     * @param $access
     * @param $useraccess
     * @param $users
     */
    public function __construct($ap_id = null, $access = null, $useraccess = null, $users = null)
    {
        $this->ap_id = $ap_id;
        $this->access = $access;
        $this->useraccess = $useraccess;
        $this->users = $users;
    }

    public function handleUserRequest($user_id){
            $this->users = User::get($user_id);
            $this->useraccess = UserAccess::get(0, $this->users->getId());
            $this->access = $this->parseUserAccessFromArray($this->getUseraccess());
            $this->ap_id = $this->parseActivitypackageFromArray($this->getAccess());
            return $this;
    }
    public function handleAktivitypackageRequest($ap_id){
        $this->ap_id = ActivityPackage::get($ap_id);
        $this->access = AccessModel::getAccessFromApId($ap_id);
        $this->useraccess = UserAccess::get($this->access->getId());
        $this->users = $this->parseUserFromArray($this->useraccess);
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Activitypackage' => $this->arrayToJson($this->getApId()),
            'Access' =>  $this->arrayToJson($this->getAccess()),
            'UserAccess' => $this->arrayToJson($this->getUseraccess()),
            'User' => $this->arrayToJson($this->getUsers()),
        ];
    }

    private function arrayToJson($array){
        if(is_array($array)){
            try{
                $data = [];
                foreach ($array as $obj){
                    $data[] = $obj->jsonSerialize();
                }
                return $data;
            }catch (Exception $ex){
                return null;
            }
        }
        else{
            return $array->jsonSerialize();
        }
    }

    private function parseUserFromArray($array){
        try{
            $data = [];
            foreach ($array as $usr){
                $userId = $usr->getUId();
                $data[] = User::get($userId);
            }
            return $data;
        }catch (Exception $ex){
            return null;
        }
    }
    private function parseUserAccessFromArray($array){
        try{
            $data = [];
            foreach ($array as $access){
                $accessId = $access->getAId();
                $data[] = AccessModel::get($accessId);
            }
            return $data;
        }catch (Exception $ex){
            return null;
        }
    }
    private function parseActivitypackageFromArray($array){
        try{
            $data = [];
            foreach ($array as $access_ap){
                $apId = $access_ap->getApId();
                $data[] = ActivityPackage::get($apId);
            }
            return $data;
        }catch (Exception $ex){
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getApId()
    {
        return $this->ap_id;
    }

    /**
     * @param mixed $ap_id
     */
    public function setApId($ap_id)
    {
        $this->ap_id = $ap_id;
    }

    /**
     * @return Access|null
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param Access|null $access
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * @return array|null
     */
    public function getUseraccess()
    {
        return $this->useraccess;
    }

    /**
     * @param array|null $useraccess
     */
    public function setUseraccess($useraccess)
    {
        $this->useraccess = $useraccess;
    }

    /**
     * @return array|User|null
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param array|User|null $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

}