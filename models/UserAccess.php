<?php

class UserAccess implements DatabaseObject, JsonSerializable
{
    private $a_id;
    private $u_id;

    /**
     * UserAccess constructor.
     * @param $a_id
     * @param $u_id
     */
    public function __construct($a_id, $u_id)
    {
        $this->a_id = $a_id;
        $this->u_id = $u_id;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function jsonSerialize()
    {
        return [
            "FK_AccessU_ID" => $this->getAId(),
            "FK_User_ID" => $this->getUId(),
        ];
    }


    // CRUD Operations

    public static function get($id, $user_id = null)
    {
        $data = [];
        $db = Database::connect();
        if($user_id == null){
            $sql = 'SELECT * FROM tbl_User_Access WHERE FK_AccessU_ID = ?;';
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id));
        }
        else{
            $sql = 'SELECT * FROM tbl_User_Access WHERE FK_User_ID = ?;';
            $stmt = $db->prepare($sql);
            $stmt->execute(array($user_id));
        }
        $objs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($objs == null) {
            return null;
        } else {
            foreach ($objs as $obj) {
                $data[] = new UserAccess($obj['FK_AccessU_ID'], $obj['FK_User_ID']);
            }
        }
        Database::disconnect();
        return $data;
    }

    static public function delete($id)
    {
        $db = Database::connect();
        $sql = 'DELETE FROM tbl_User_Access Where FK_AccessU_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        Database::disconnect();
    }
    static public function deleteUser($a_id, $u_id){
        $db = Database::connect();
        $sql = 'DELETE FROM tbl_User_Access Where FK_AccessU_ID = ? AND Where FK_User_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($a_id, $u_id));
        Database::disconnect();
    }

    public function update()
    {
        $db = Database::connect();
        $sql = 'UPDATE tbl_User_Access SET FK_User_ID = ? WHERE FK_AccessU_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getAId(), $this->getUId()));
        Database::disconnect();
    }

    public function create()
    {
        $db = Database::connect();
        $sql = 'Insert INTO tbl_User_Access (FK_AccessU_ID, FK_User_ID) values (?,?);';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getAId(), $this->getUId()));
        return $db->lastInsertId();
        Database::disconnect();
    }

    public function save()
    {
        if ($this->validate()) {
            if ($this->getAId() != null && $this->getAId() > 0 && $this->getUId() != null && $this->getUId() > 0) {
                $this->update();
                return true;
            } else {
                $this->setAId($this->create());
                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getAId()
    {
        return $this->a_id;
    }

    /**
     * @param mixed $a_id
     */
    public function setAId($a_id)
    {
        $this->a_id = $a_id;
    }

    /**
     * @return mixed
     */
    public function getUId()
    {
        return $this->u_id;
    }

    /**
     * @param mixed $u_id
     */
    public function setUId($u_id)
    {
        $this->u_id = $u_id;
    }
    // Getter & Setter


}


?>

