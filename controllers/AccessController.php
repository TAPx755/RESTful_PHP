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

class AccessController
{
    private $ap_id;
    private $access;
    private $useraccess;
    private $users;

    /**
     * AccessController constructor.
     * @param $access
     * @param $user
     */
    public function __construct($ap_id)
    {
        $this->ap_id = $ap_id;
        $this->access = AccessModel::getAccessFromApId($ap_id);
        $this->useraccess = UserAccess::get($this->access->getId());
        $this->users = $this->parseUserFromArray($this->useraccess);
    }

    public function parseUserFromArray($array){
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