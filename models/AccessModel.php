<?php
/**
 * Created by PhpStorm.
 * User: vivi_mac
 * Date: 2019-06-01
 * Time: 21:09
 */

class AccessModel
{
    private $id;
    private $ap_id;

    /**
     * AccessModel constructor.
     * @param $id
     * @param $ap_id
     */
    public function __construct($id, $ap_id)
    {
        $this->id = $id;
        $this->ap_id = $ap_id;
    }

    // CRUD Operations

    public function save()
    {
        if ($this->validate()) {
            if ($this->getId() != null && $this->getId() > 0) {
                $this->update();
                return true;
            } else {
                $this->setId($this->create());
                return true;
            }
        }
        return false;
    }

    public function create()
    {
        $db = Database::connect();
        $sql = 'Insert INTO tbl_Access (a_ID, FK_Activitypackage_ID) values (?,?);';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getId(), $this->getAp_Id()));
        return $db->lastInsertId();
        Database::disconnect();
    }

    public static function get($id)
    {
        $db = Database::connect();
        $sql = 'SELECT * FROM tbl_Access WHERE a_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj == null) {
            return null;
        } else {
            $data = new Access($obj['a_ID'], $obj['FK_Activitypackage_ID']);
        }
        Database::disconnect();
        return $data;
    }

    static public function delete($id)
    {
        $db = Database::connect();
        $sql = 'DELETE FROM tbl_Access WHERE a_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        Database::disconnect();
    }

    public function update()
    {
        $db = Database::connect();
        $sql = 'UPDATE tbl_Access SET FK_Activtiypackage = ? WHERE a_ID = ?;';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->getApId(), $this->getId()));
        Database::disconnect();
    }

    // Getter and Setter
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
    public function getApId()
    {
        return $this->ap_id;
    }

    /**
     * @param mixed $ap_id
     */
    public function setApId($ap_id)
    {
        $this->ap_id = $ap_id;
    }
}