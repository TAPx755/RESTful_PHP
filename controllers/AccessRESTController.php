<?php
/**
 * Created by PhpStorm.
 * User: vivi_mac
 * Date: 2019-06-13
 * Time: 16:27
 */

require_once "models/UserAccess.php";
require_once "models/AccessModel.php";
require_once "RESTController.php";

class AccessRESTController extends RESTController
{
    public function handleRequest()
    {
        if ($this->token != null) {
            $user = new User(null, null, null, null, null, null);
            $user->setToken($this->token);
            $id = $user->getIdFromToken();
            $privilege = $user->getPrivilegeFromToken();
            if ($id == false) {
                $this->response("User not found", 401);
                die();
            }
            if ($privilege == false) {
                $this->response("Privilege not found", 401);
                die();
            }

            if ($user->validateToken()) {
                switch ($this->method) {
                    case 'PUT':
                        $this->handlePUTRequest($user);
                        break;
                    case 'DELETE':
                        $this->handleDELETERequest($user);
                        break;
                    case 'GET':
                        $this->handleGETRequest($user);
                        break;
                    case 'POST':
                        $this->handlePOSTRequest($user);
                        break;
                    default :
                        $this->response('Method not allowed', 405);
                }
            } else {
                $this->response("Token invalid", 401);
            }
        }
    }

    public function handlePUTRequest()
    {
        if ($this->verb == null && sizeof($this->args) == 1) {
            $model = UserAccess::get($this->args[0]);
            $model->setUId($this->file['FK_User_ID']);
            if ($model->validate()) {
                $model->update();
                $this->response('OK', 200);
            } else {
                $this->response($model->getErrors(), 400);
            }
        } else {
            $this->response('Not Found', 404);
        }

    }

    public function handleDELETERequest()
    {
        if ($this->verb == null && sizeof($this->args) == 1) {
            UserAccess::delete($this->args[0]);
            $this->response('OK', 200);
        } else {
            $this->response('Not Found', 404);
        }
    }

    public function handleGETRequest($user)
    {
        if ($this->verb == 'user' && $user->getPrivilege() != 'Guest') {
            //http://10.10.10.191/PHP_Storm/RESTful_PHP/api/access/user
            $model = UserAccess::get(null, $user->getId());
            $access = $model->getAId();
            $accessmodel = [];
            for ($i = 0; $i < count($access); $i++) {
                $accessmodel[] = AccessModel::get((int)$access[$i]);
            }
            $aps = [];
            for ($i = 0; $i < count($accessmodel); $i++) {
                $aps[] = ActivityPackage::get((int)($accessmodel[$i])->getApId());
            }
            $this->response($aps);
        } else if ($this->verb == 'activitypackage' && sizeof($this->args) == 1 && $user->getPrivilege() != 'Guest') {
            //http://10.10.10.191/PHP_Storm/RESTful_PHP/api/access/activitypackage/6
            $model = Activitypackage::get($this->args[0]);
            if ($model->getFkOwner() == $user->getId()) {
                $accessmodel = AccessModel::getAccessFromApId($model->getId());
                $useraccess = UserAccess::get($accessmodel->getId());
                $access = $useraccess->getUId();
                $users = [];
                for ($i = 0; $i < count($access); $i++) {
                    $users[] = User::getOnlyIdAndName((int)$access[$i]);
                }
                $this->response(array_merge($model->jsonSerialize(), $users));
            } else {
                $this->response('Not Authorized', 401);
            }
        } else if ($this->verb == 'selectionuser' && $user->getPrivilege() != 'Guest') {
            $model = User::getAllOnlyIdAndName();
            $this->response($model, 200);
        }else {
            $this->response('Not Authorized', 401);
        }
    }

    public function handlePOSTRequest($user)
    {
        if ($user->getPrivilege() != 'Guest') {
            $model = new UserAccess('', '');
            $model->setAId($this->file['FK_AccessU_ID']);
            $model->setUId($this->file['FK_User_ID']);
            if ($model->validate()) {
                $model->create();
                $this->response('OK', 201);
            } else {
                $this->response($model->getErrors(), 400);
            }
        }
    }

}