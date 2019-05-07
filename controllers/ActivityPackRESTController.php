<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-02-21
 * Time: 17:37
 */

require_once "RESTController.php";

require_once __DIR__."/../models/User.php";
require_once __DIR__."/../models/ActivityPackage.php";


class ActivityPackRESTController extends RESTController
{
    public function handleRequest()
    {
        $user = new User(null,null,null,$this->token,null,null,null);
        $user->setId($user->getIdFromToken());

        if($this->token != null && $user->validateToken())
        {
            switch($this->method)
            {
                case 'POST': $this->handlePOSTRequest();
                    break;
                case 'PUT': $this->handlePUTRequest();
                    break;
                case 'DELETE': $this->handleDELETERequest();
                    break;
                case 'GET': $this->handleGETRequest();
                    break;
                default : $this->response('Method not allowed', 405);
            }
        }
        else
        {
            $this->response('Token not found', 401);
        }
    }
    public function handleGETRequest()
    {
        if ($this->verb == null && sizeof($this->args) == 0)
        {
            $model = ActivityPackage::getAll();
            $this->response($model);
        }
        else if($this->verb == null && sizeof($this->args) == 1)
        {
            $model = ActivityPackage::get($this->args[0]);
            $this->response($model);
        }
        else
        {
            $this->response('Bad Request', 400);
        }
    }

    public function handlePOSTRequest()
    {
        $model = new ActivityPackage(null, '', '', '', '','','', null,'', '');

        $model->setNote($this->file['ap_Note']);
        $model->setName($this->file['ap_Name']);
        $model->setLocation($this->file['ap_Location']);
        $model->setStreet($this->file['ap_Street']);
        $model->setStreetNr($this->file['ap_StreetNr']);
        $model->setDate($this->file['ap_Date']);
        $model->setTime($this->file['ap_Time']);
        $model->setFkOwner($this->file['FK_OwnerUser_ID']);
        $model->setDone($this->file['ap_Done']);

        if($model->save())
        {
            $this->response('OK', 201);
        }
        else
        {
            $this->response($model->getErrors(), 400);
        }

    }

    /*
     *
     * PUT api.php?r=credentials/25 -> args[0] = 25
     *
     */
    public function handlePUTRequest()
    {

        if($this->verb == null && sizeof($this->args) == 1)
        {
            $model = ActivityPackage::get($this->args[0]);

            $model->setNote($this->file['ap_Note']);
            $model->setNote($this->file['ap_Name']);
            $model->setStreet($this->file['ap_Street']);
            $model->setStreetNr($this->file['ap_StreetNr']);
            $model->setDate($this->file['ap_Date']);
            $model->setTime($this->file['ap_Time']);

            if($model->save())
            {
                $this->response('OK', 200);
            }
            else
            {
                $this->response($model->getErrors(), 400);
            }
        }
        else
        {
            $this->response('Not Found', 404);
        }

    }

    public function handleDELETERequest()
    {
        if($this->verb == null && sizeof($this->args) == 1)
        {
            ActivityPackage::delete($this->args[0]);
            $this->response('OK', 200);

        }
        else
        {
            $this->response('Not Found', 404);
        }
    }

}