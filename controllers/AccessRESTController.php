<?php
/**
 * Created by PhpStorm.
 * User: vivi_mac
 * Date: 2019-06-13
 * Time: 16:27
 */

require_once "models/UserAccess.php";
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
        if (sizeof($this->args) == 1 && $user->getPrivilege() != 'Guest') {
            $model = UserAccess::get($this->args[0]);
            $this->response($model);
        } else {
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