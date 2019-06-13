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

    public static function get($id, $user_id = null)
    {
        $data = [];
        $db = Database::connect();
        if ($user_id == null) {
            $sql = 'SELECT * FROM tbl_User_Access WHERE FK_AccessU_ID = ?;';
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id));
        } else {
            $sql = 'SELECT * FROM tbl_User_Access WHERE FK_User_ID = ?;';
            $stmt = $db->prepare($sql);
            $stmt->execute(array($user_id));
        }
        $objs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($objs == null) {
            return null;
        } else {
            if ($user_id != null) {
                foreach ($objs as $obj) {
                    $data[] = $obj['FK_AccessU_ID'];
                }
                return new UserAccess($data, $objs[0]['FK_User_ID']);
            } else {
                foreach ($objs as $obj) {
                    $data[] = $obj['FK_User_ID'];
                }
                return new UserAccess($objs[0]['FK_AccessU_ID'], $data);
            }
        }
        Database::disconnect();
    }

    public function jsonSerialize()
    {
        return [
            "FK_AccessU_ID" => $this->getAId(),
            "FK_User_ID" => $this->getUId(),
        ];
    }


    // CRUD Operations

    public function getAll()
    {
        // Not Needed
    }

    public function update()
    {
        UserAccess::delete((int)$this->getAId());
        $this->create();
    }

    static public function delete($id)
    {
        $db = Database::connect();
        $sql = 'DELETE FROM tbl_User_Access Where FK_AccessU_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        Database::disconnect();
    }

    public function create()
    {
        $ary = $this->getUId();
        for ($i = 0; $i < count($ary); $i++){
            $db = Database::connect();
            $sql = 'Insert INTO tbl_User_Access (FK_AccessU_ID, FK_User_ID) values (?,?);';
            $stmt = $db->prepare($sql);
            $stmt->execute(array($this->getAId(), $ary[$i]));
            Database::disconnect();
        }
    }

    public function validate()
    {
        return true; //TODO Just numbers to validate
    }
    // Getter & Setter

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
}

?>

