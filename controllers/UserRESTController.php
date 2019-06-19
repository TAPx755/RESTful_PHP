<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-03-27
 * Time: 18:33
 */

require_once "RESTController.php";
//include __DIR__."/RESTController.php";
require_once __DIR__."/../models/User.php";

class UserRESTController extends RESTController
{
    public function __construct()
    {
        try
        {
            parent::__construct();
        }
        catch(Exception $e)
        {
            echo $e;
        }
    }

    public function handleRequest()
    {

        if($this->token == null)
        {
            if($this->method == 'POST')
            {
                $this->handlePOSTRequest();
            }
            else
            {
                $this->response("Only POST allowed without Token!", 401);
            }
        }
        else
        {
            $user = new User(null,null,null,null,null,null);
            $user->setToken($this->token);
            $id = $user->getIdFromToken();
            $privilege = $user->getPrivilegeFromToken();

            if($id == false)
            {
                $this->response("User not found", 401);
            }
            if($privilege == false)
            {
                $this->response("Privilege not found", 401);
            }

            if($user->validateToken())
            {
                switch($this->method)
                {
                    case 'PUT': $this->handlePUTRequest($user);
                        break;
                    case 'DELETE': $this->handleDELETERequest($user);
                        break;
                    case 'GET': $this->handleGETRequest($user);
                        break;
                    default : $this->response('Method not allowed', 405);
                }
            }
            else
            {
                $this->response("Token invalid", 401);
            }
        }
    }
    public function handleGETRequest($user)
    {

        if(sizeof($this->args) == 0 && $user->getPrivilege() == 'Admin')
        {
            $model = User::getAll();
            $this->response($model, 200);
        }
        else if(sizeof($this->args) == 1 && ($user->getPrivilege() == 'Normal' && $user->getId() == $this->args[0]))
        {
            $model = User::get($this->args[0]);
            $this->response($model, 200);
        }
        else if(sizeof($this->args) == 1 && $user->getPrivilege() == 'Admin')
        {
            $model = User::get($this->args[0]);
            $this->response($model, 200);
        }
        else
        {
            $this->response('Not Authorized', 401);
        }
    }
    public function handleDELETERequest($user)
    {
        if(sizeof($this->args) == 1 && $user->getPrivilege() == 'Admin')
        {
            User::delete($this->args[0]);
            $this->response('OK', 200);
        }
        else
        {
            $this->response('Not found', 404);
        }
    }
    public function handlePOSTRequest()
    {
        //For login process
        if($this->verb == 'login' && sizeof($this->args) == 0)
        {

            $loginUser = new User(null,null,null,null,null,null);

            $loginUser->setEmail($this->file['u_Email']);
            $loginUser->setPassword($this->file['u_Password']);

            $foundUserDB = $loginUser->getUserFromEmail();


            if($foundUserDB != null)
            {
                if($loginUser->checkPassword($foundUserDB))
                {
                    $foundUserDB->setToken($foundUserDB->generateToken());
                    $foundUserDB->saveToken();
                    $this->response($foundUserDB->getToken(), 200);
                }
                else
                {
                    $this->response("Invalid Credentials", 401);
                }
            }
            else
            {
                $this->response("Not Found", 404);
            }
        }
        //For register process
        else if($this->verb == null && sizeof($this->args) == 0)
        {
            $user = new User(null,null,null,null,null, null);

            $user->setName($this->file['u_Name']);
            $user->setPassword($this->file['u_Password']);
            $user->setEmail($this->file['u_Email']);
            $user->setPrivilege('Guest');

            if($user->save())
            {
                $this->response('OK', 200);
            }
            else
            {
                $this->response($user->getErrors(), 400);
            }
        }
        else
        {
            $this->response('Bad Request', 400);
        }
    }
    public function handlePUTRequest($user)
    {
       if(sizeof($this->args) == 1 && $user->getPrivilege() == 'Admin') {

           $user = User::get($this->args[0]);


           //$user->setName($this->file['u_Name']);
           //$user->setPassword(password_hash($this->file['u_Password'], PASSWORD_BCRYPT));
           //$user->setEmail($this->file['u_Email']);
           $user->setPrivilege($this->file['u_Privilege']);
           $user->setToken(null);

           if ($user->save()) {
               $this->response('OK', 200);
           } else {
               $this->response($user->getErrors(), 400);
           }
       }
       else
       {
           $this->response('Not Found', 404);
       }
    }
}