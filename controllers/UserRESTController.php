<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-03-27
 * Time: 18:33
 */

require_once "RESTController.php";
require_once  "models/User.php";

class UserRESTController extends RESTController
{
    public function handleRequest()
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
    public function handleGETRequest()
    {
        if($this->verb == null && sizeof($this->args) == 0)
        {
            $model = User::getAll();
            $this->response($model, 200);
        }
        else if($this->verb == null && sizeof($this->args) > 0)
        {
            $model = User::get($this->args[0]);
            $this->response($model, 200);
        }
        else
        {
            $this->response('Bad request', 400);
        }
    }
    public function handleDELETERequest()
    {
        if($this->verb == null && sizeof($this->args) == 1)
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

            $loginUser = new User(null,null,null,null,null,null,null);

            $loginUser->setEmail($this->file['u_Email']);
            $loginUser->setPassword($this->file['u_Password']);

            $foundUserDB = $loginUser->getUserFromEmail();

            if($foundUserDB != null)
            {
                if($loginUser->checkPassword($foundUserDB))
                {
                    $foundUserDB->saveInSession();

                    $this->response($foundUserDB->getId(), 200);
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
            $user = new User(null,null,null,null,null,null,null);

            $user->setName($this->file['u_Name']);
            $user->setPassword(password_hash($this->file['u_Password'], PASSWORD_BCRYPT));
            $user->setSalt("TODO METHOD");
            $user->setEmail($this->file['u_Email']);

            //Default Werte für einen neuen User (Rechte->3 = Gast, Unlocked->False = Gesperrt)
            $user->setUnlocked(false);
            $user->setFkPrivilege(3);

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
    public function handlePUTRequest()
    {
       if($this->verb == null && sizeof($this->args)==1)
       {
           $user = User::get($this->args[0]);


           $user->setName($this->file['u_Name']);
           $user->setPassword($this->file['u_Password']);
           $user->setSalt("TODO METHOD");
           $user->setEmail($this->file['u_Email']);
           $user->setUnlocked($this->file['u_Unlocked']);
           $user->setFkPrivilege($this->file['FK_Privilege_ID']);

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
           $this->response('Not Found', 404);
       }
    }
}