<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-03-27
 * Time: 18:30
 */

class User implements DatabaseObject, JsonSerializable
{
    private $id;
    private $name;
    private $password;
    private $salt;
    private $email;
    private $unlocked;

    private $fkPrivilege;

    private $errors;


    function __construct($id=0, $name, $password, $salt, $email, $unlocked, $fkPrivilege)
    {
        $this->id=$id;
        $this->name=$name;
        $this->password=$password;
        $this->salt=$salt;
        $this->email=$email;
        $this->unlocked=$unlocked;
        $this->fkPrivilege=$fkPrivilege;

        $this->errors = [];
    }

    public function save()
    {
            if($this->getId() != null && $this->getId() > 0)
            {
                $this->update();
                return true;
            }
            else
            {
                $this->setId($this->create());
                return true;
            }
            return false;
    }


    public function validate()
    {
        return $this->validateHelper('name', $this->getName(), 30) &
            $this->validateHelper('password', $this->getPassword(), 32) &
            $this->validateHelper('email', $this->getEmail(), 30);
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
            return false;
        }
        return true;
    }

    public function getUserFromEmail()
    {
        $db = Database::connect();
        $sql = 'SELECT u_ID, u_Email, u_Password, u_Salt FROM tbl_User WHERE u_Email LIKE ?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == null)
        {
            return null;
        }
        else
        {
            return new User($user['u_ID'], null, $user['u_Password'], $user['u_Salt'], $user['u_Email'],null,null);
        }
    }
    public function checkPassword($userFromDB)
    {
        return password_verify($this->getPassword(), $userFromDB->getPassword());
    }

    public function saveInSession()
    {
        $_SESSION[$this->getEmail()] = $this->getId();
    }

    public function create()
    {
        $db = Database::connect();
        $sql = 'INSERT INTO tbl_User (u_Name, u_Password, u_Salt, u_Email, u_Unlocked, FK_Privilege_ID) values (?,?,?,?,?,?)';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getName(), $this->getPassword(), $this->getSalt(), $this->getEmail(), $this->getUnlocked(), $this->getFkPrivilege()));
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
            return new User($user['u_ID'], $user['u_Name'], $user['u_Password'], $user['u_Salt'], $user['u_Email'], $user['u_Unlocked'], $user['FK_Privilege_ID']);
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
                $data[] = new User($user['u_ID'], $user['u_Name'], $user['u_Password'], $user['u_Salt'], $user['u_Email'], $user['u_Unlocked'], $user['FK_Privilege_ID']);
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
        $sql = 'UPDATE tbl_User SET u_Name = ?, u_Password = ?, u_Salt = ?, u_Email = ?, u_Unlocked = ?, FK_Privilege_ID = ? WHERE u_ID=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getName(), $this->getPassword(), $this->getPassword(), $this->getSalt(), $this->getUnlocked(), $this->getFkPrivilege(), $this->getId()));
        Database::disconnect();
    }

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
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
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
            "u_Salt" => $this->getSalt(),
            "u_Email" => $this->getEmail(),
            "u_Unlocked" => $this->getUnlocked(),
            "FK_Privilege_ID" => $this->getFkPrivilege()
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