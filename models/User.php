<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-03-27
 * Time: 18:30
 */

require_once __DIR__."/../auth/JWTToken.php";
require_once __DIR__."/../models/DatabaseObject.php";
//require_once __DIR__."/../models/Privilege.php";


class User implements DatabaseObject, JsonSerializable
{
    private $id;
    private $name;
    private $password;
    private $token;
    private $email;
    private $unlocked;

    private $fkPrivilege;

    private $errors;


    function __construct($id=0, $name, $password, $token, $email, $unlocked, $fkPrivilege)
    {
        $this->id=$id;
        $this->name=$name;
        $this->password=$password;
        $this->token=$token;
        $this->email=$email;
        $this->unlocked=$unlocked;
        $this->fkPrivilege=$fkPrivilege;

        $this->errors = [];
    }

    public function save()
    {
        if ($this->validate()) {
            echo "save";

            /*
            if ($this->getId() != null && $this->getId() > 0) {
                $this->update();
                return true;
            } else {
                $this->setId($this->create());
                return true;
            }
            return false;*/
        }else{
            echo "nosave";
        }

    }


    public function validate()
    {
        return $this->validateName("name", $this->getName())&
                $this->validateEmail("email", $this->getEmail())&
                $this->validatePassword("passwort", $this->getPassword());
    }

    public function validateHelper($label, $value, $length)
    {
        if(strlen($value) > $length)
        {
            $errors[$label] = $label.' darf die Zeichen von '.$length.' nicht überschreiten';
            return false;
        }
        if(strlen($value) == 0)
        {
            $errors[$label] = $label.' darf nicht leer sein';
            var_dump($errors);
            return false;
        }
        return true;
    }

    public function validateName($label, $value){
        $reg = "#^[A-Za-z.,-öÖäÄüÜß]*$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " darf keine Sonderzeichen enthalten";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*
        else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 256)){
            return true;
        }*/
        else{
            return true;
        }
    }

    public function validatePassword($label, $value){
        // TODO: PASSWORD POLICY ?
        if (strlen($value) <= "8") {
            $errors[$label] = "Dein Passwort muss mindestens 8 Zeichen lang sein!";
            var_dump($errors);
            return false;
        }
        elseif(!preg_match("#[0-9]+#",$value)) {
            $errors[$label] = "Dein Passwort muss mindestens eine Zahl beinhalten!";
            var_dump($errors);
            return false;
        }
        elseif(!preg_match("#[A-Z]+#",$value)) {
            $errors[$label] = "Dein Passwort muss mindestens einen Großbuchstaben beinhalten!";
            var_dump($errors);
            return false;
        }
        elseif(!preg_match("#[a-z]+#",$value)) {
            $errors[$label] = "Dein Passwort muss mindestens einen Kleinbuchstaben beinhalten!";
            var_dump($errors);
        }
        else {
            $errors[$label] = "Bitte überprüfen Sie, ob Sie Ihr Passwort eingegeben haben!";
            var_dump($errors);
        }

    }

    public function validateEmail($label, $value){
        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        else if (!$this->validateHelper($label, $value,256)){
            return false;
        }
        else{
            $errors[$label] = $label. " ist keine gültige E-Mail Adresse";
            return false;
        }

    }

    public function getPrivilege() //FK Privilege
    {
        $db = Database::connect();
        $sql = 'SELECT p.p_ID, p.p_Description, p.p_Name, p.p_Read, p.p_Write, p.p_GrantUser, p.p_DeleteUser, u.u_Id, u.u_Name FROM tbl_privilege p INNER JOIN tbl_User u on u.u_ID = p.p_ID WHERE u_ID = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getId()));
        $privilege = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        return new Privilege($privilege['p_ID'], $privilege['p_Name'], $privilege['p_Description'], $privilege['p_Read'], $privilege['p_Write'], $privilege['p_GrantUser'], $privilege['p_DeleteUser']);
    }

    public function create()
    {
        $db = Database::connect();
        $sql = 'INSERT INTO tbl_User (u_Name, u_Password, u_Token, u_Email, u_Unlocked, FK_Privilege_ID) values (?,?,?,?,?,?)';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getName(), $this->getPassword(), $this->getToken(), $this->getEmail(), $this->getUnlocked(), $this->getFkPrivilege()));
        return $db->lastInsertId();
        Database::disconnect();
    }

    public static function get($id)
    {
        $db = Database::connect();
        $sql = 'SELECT * FROM tbl_User WHERE u_ID=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user == null)
        {
            return null;
        }
        else
        {
            $tmpUser = new User($user['u_ID'], $user['u_Name'], $user['u_Password'], $user['u_Token'], $user['u_Email'], $user['u_Unlocked'], null);
            $tmpUser->setFkPrivilege($tmpUser->getPrivilege());
            return $tmpUser;
        }
        Database::disconnect();
    }

    public function getAll()
    {
        $data = [];

        $db = Database::connect();
        $sql = 'SELECT * FROM tbl_User';
        $stmt=$db->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Database::disconnect();
        
        if($users == null)
        {
            return null;
        }
        else
        {
            foreach ($users as $user)
            {
                $data[] = new User($user['u_ID'], $user['u_Name'], $user['u_Password'], $user['u_Token'], $user['u_Email'], $user['u_Unlocked'], $user['FK_Privilege_ID']);
            }
        }

        return $data;
    }

    static public function delete($id)
    {
        $db = Database::connect();
        $sql = 'DELETE FROM tbl_User WHERE u_ID = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        Database::disconnect();
    }

    public function update()
    {
        $db = Database::connect();
        $sql = 'UPDATE tbl_User SET u_Name = ?, u_Password = ?, u_Token = ?, u_Email = ?, u_Unlocked = ?, FK_Privilege_ID = ? WHERE u_ID=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getName(), $this->getPassword(), $this->getPassword(), $this->getToken(), $this->getUnlocked(), $this->getFkPrivilege(), $this->getId()));
        Database::disconnect();
    }

    //AUTH SECTION
    public function getUserFromEmail()
    {
        $db = Database::connect();
        $sql = 'SELECT u_ID, u_Email, u_Password, u_Token FROM tbl_User WHERE u_Email LIKE ?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getEmail()));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == null)
        {
            return null;
        }
        else
        {
            return new User($user['u_ID'], null, $user['u_Password'], $user['u_Token'], $user['u_Email'],null,null);
        }
    }

    public function checkPassword($userFromDB)
    {
        return password_verify($this->getPassword(), $userFromDB->getPassword());
    }

    public function generateToken()
    {
        $token = array(
            "username" => $this->getEmail(),
            "password" => $this->getPassword(),
            "id" => $this->getId()
        );
        return JWTToken::generateToken($token);
    }

    public function getIdFromToken()
    {
        if(JWTToken::parseToken($this->getToken()) != false)
        {
            $id = JWTToken::parseToken($this->getToken())->id;
            return $id;
        }
        else
        {
            return false;
        }
    }

    public function parseToken()
    {
        return JWTToken::parseToken($this->getToken());
    }

    public function saveToken()
    {
        $db = Database::connect();
        $sql = "UPDATE tbl_User SET u_Token = ? WHERE u_ID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getToken(),$this->getId()));
        Database::disconnect();
    }
    public function validateToken()
    {
        if(JWTToken::validateToken($this->getToken()))
        {
            $db = Database::connect();
            $sql = "SELECT u_Token FROM tbl_User WHERE u_ID = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($this->getId()));
            $tokenFromDB = $stmt->fetch(PDO::FETCH_ASSOC);
            $tokenFromDB = $tokenFromDB['u_Token'];
            Database::disconnect();

            if($tokenFromDB == null)
            {
                return false;
            }
            else if(strcmp($tokenFromDB, $this->getToken()) == 0)
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }
    //END OF AUTH SECTION

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUnlocked()
    {
        return $this->unlocked;
    }

    /**
     * @param mixed $unlocked
     */
    public function setUnlocked($unlocked)
    {
        $this->unlocked = $unlocked;
    }

    /**
     * @return mixed
     */
    public function getFkPrivilege()
    {
        return $this->fkPrivilege;
    }

    /**
     * @param mixed $fkPrivilege
     */
    public function setFkPrivilege($fkPrivilege)
    {
        $this->fkPrivilege = $fkPrivilege;
    }


    public function jsonSerialize()
    {
        return [
          "u_ID" => $this->getId(),
          "u_Name" => $this->getName(),
          "u_Password" => $this->getPassword(),
            "u_Token" => $this->getToken(),
            "u_Email" => $this->getEmail(),
            "u_Unlocked" => $this->getUnlocked(),
            "FK_Privilege_ID" => [
                "p_Name" => $this->getFkPrivilege()->getName(),
                "p_Description" => $this->getFKPrivilege()->getDescription(),
                "p_Read" => $this->getFkPrivilege()->getRead(),
                "p_Write" => $this->getFkPrivilege()->getWrite(),
                "p_GrantUser" => $this->getFkPrivilege()->getGrantUser(),
                "p_DeleteUser" => $this->getFkPrivilege()->getDeleteUser()
            ]
        ];
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }



}