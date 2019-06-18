<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-02-21
 * Time: 17:37
 */

require_once "models/ActivityPackage.php";
require_once "RESTController.php";

class ActivityPackRESTController extends RESTController
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
        } else {
            $this->response("Token invalid", 401);
        }
    }

    public function handlePUTRequest($user)
    {
        //WAIT FOR ACCESS
        if ($this->verb == null && sizeof($this->args) == 1 && $user->getPrivilege() != 'Guest') {
            $model = ActivityPackage::get($this->args[0]);

            if ($user->getId() == $model->getFkOwner()) {
                $model->setNote($this->file['ap_Note']);
                $model->setName($this->file['ap_Name']);
                $model->setLocation($this->file['ap_Location']);
                $model->setStreet($this->file['ap_Street']);
                $model->setStreetNr($this->file['ap_StreetNr']);
                $model->setDate($this->file['ap_Date']);
                $model->setTime($this->file['ap_Time']);

                if ($model->save()) {
                    $this->response('OK', 200);
                } else {
                    $this->response($model->getErrors(), 400);
                }
            } else {
                $this->response('Not Authorized', 401);
            }

        } else if ($this->verb == "done" && sizeof($this->args) == 1 && $user->getPrivilege() != 'Guest') {
            $model = ActivityPackage::get($this->args[0]);
            $model->setDone($this->file['ap_Done']);

            if ($model->save()) {
                $this->response('OK', 200);
            } else {
                $this->response($model->getErrors(), 400);
            }

        } else {
            $this->response('Not Found', 404);
        }

    }

    public function handleDELETERequest($user)
    {
        $model = ActivityPackage::get($this->args[0]);
        if ($user->getId() == $model->getFkOwner()) {
            if ($this->verb == null && sizeof($this->args) == 1) {
                ActivityPackage::delete($this->args[0]);
                $this->response('OK', 200);

            } else {
                $this->response('Not Found', 404);
            }
        }
        else {
            $this->response('Not Authorized', 401);
        }
    }

    /*
     *
     * PUT api.php?r=credentials/25 -> args[0] = 25
     *
     */

    public function handleGETRequest($user)
    {
        if (sizeof($this->args) == 0 && $user->getPrivilege() == 'Admin') {
            $model = ActivityPackage::getAll();
            $this->response($model,200);
        } else if ($this->verb != 'search' && sizeof($this->args) == 1 && ($user->getPrivilege() == 'Admin')) {
            $model = ActivityPackage::get($this->args[0]);
            $this->response($model,200);
        } else if (sizeof($this->args) == 0 && $user->getPrivilege() != 'Guest') //ap/user/1
        {
            //$user = User::get($this->args[0]);
            $model = ActivityPackage::getAll($user);
            $this->response($model, 200);
        } else if (($this->verb = 'search' && sizeof($this->args) == 1) && $user->getPrivilege() != 'Guest'){ //ap/user/1/Pflastern
            $model = ActivityPackage::getAll($user, $this->args[0]);
            $this->response($model, 200);
        } else {
            $this->response('Not Authorized', 401);
        }
    }

    public function handlePOSTRequest($user)
    {
        if ($user->getPrivilege() != 'Guest') {
            $model = new ActivityPackage(null, '', '', '', '', '', '', null, '', '');

            $model->setNote($this->file['ap_Note']);
            $model->setName($this->file['ap_Name']);
            $model->setLocation($this->file['ap_Location']);
            $model->setStreet($this->file['ap_Street']);
            $model->setStreetNr($this->file['ap_StreetNr']);
            $model->setDate($this->file['ap_Date']);
            $model->setTime($this->file['ap_Time']);
            $model->setFkOwner($user->getId());
            $model->setDone($this->file['ap_Done']);

            if ($model->save()) {
                $this->response($model->getId(), 201);
            } else {
                $this->response($model->getErrors(), 400);
            }
        }
    }

}
