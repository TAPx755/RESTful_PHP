<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-02-21
 * Time: 17:29
 */

require_once "DatabaseObject.php";

class ActivityPackage implements DatabaseObject, JsonSerializable
{
    private $id;
    private $name;
    private $location;
    private $note;
    private $street;
    private $streetNr;
    private $date;
    private $time;
    private $done;

    private $fkOwner;

    private $errors;

    public function __construct($id=0, $name, $note, $street, $streetNr, $date, $time, $fkOwner, $done, $location)
    {
        $this->id = $id;
        $this->note = $note;
        $this->street = $street;
        $this->streetNr = $streetNr;
        $this->date = $date;
        $this->time = $time;
        $this->fkOwner = $fkOwner;
        $this->name = $name;
        $this->done = $done;
        $this->errors = [];
        $this->location = $location;
    }

    public function validate()
    {
        return $this->validateName("name", $this->getName()) &
            $this->validateNote("note", $this->getNote()) &
            $this->validateLocation("location", $this->getLocation()) &
            $this->validateStreet("street", $this->getStreet()) &
            $this->validateStreetNr("streetNr", $this->getStreetNr()) &
            $this->validateDate("date", $this->getDate()) &
            $this->validateTime("time", $this->getTime());
    }

    public function save()
    {
        if ($this->validate()) {
            if ($this->id != null && $this->id > 0) {
                $this->update();
            } else {
                $this->id = $this->create();
            }
            return true;
        }
        return false;
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
        $reg = "#^[ öÖäÄüÜßa-zA-Z0-9_.,-/()+*><]*$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 256)){
            return true;
        }*/
        else{
            return true;
        }
    }
    public function validateLocation($label, $value){
        $reg = "#^[ öÖäÄüÜßa-zA-Z.,-]*$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 128)){
            return true;
        }*/
        else{
            return true;
        }
    }
    public function validateNote($label, $value){
        $reg = "#^[ öÖäÄüÜßa-zA-Z0-9_.,-/()+*><&!?\"]*$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 256)){
            return true;
        }*/
        else{
            return true;
        }
    }
    public function validateStreet($label, $value){
        $reg = "#^[ ßöÖäÄüÜßa-zA-Z]*$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 256)){
            return true;
        }*/
        else{
            return true;
        }
    }
    public function validateStreetNr($label, $value){
        $reg = "#^[a-z0-9,-]*$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 10)){
            return true;
        }*/
        else{
            return true;
        }
    }
    public function validateDate($label, $value){
        $reg = "#([12][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 10)){
            return true;
        }*/
        return true;
    }
    public function validateTime($label, $value){
        $reg = "#^(?:2[0-3]|[01][0-9]):[0-5][0-9]$#";
        if (!preg_match($reg, $value)){
            $errors[$label] = $label. " beinhaltet Sonderzeichen";
            var_dump($errors);
            return false;
        }
        else if (!$this->validateHelper($label, $value, 256)){
            return false;
        }
        /*else if (preg_match($reg, $value) & $this->validateHelper($label, $value, 10)){
            return true;
        }*/
        return true;
    }

    public function create()
    {
        $db = Database::connect();
        $sql = 'INSERT INTO tbl_Activitypackage (ap_Note,ap_Name, ap_Street, ap_StreetNr, ap_Date, ap_Time, FK_OwnerUser_ID, ap_Done,ap_Location) values (?,?,?,?,?,?,?,?,?)';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->note, $this->name, $this->street, $this->streetNr, $this->date, $this->time, $this->fkOwner, $this->done, $this->location));
        return $db->lastInsertId();
        Database::disconnect();
    }

    public static function get($id)
    {
        $db = Database::connect();
        $sql = 'SELECT * FROM tbl_Activitypackage WHERE ap_ID =?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        $ap = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if($ap == null)
        {
            return null;
        }
        else
        {
            return new ActivityPackage($ap['ap_ID'], $ap['ap_Name'], $ap['ap_Note'], $ap['ap_Street'], $ap['ap_StreetNr'], $ap['ap_Date'], $ap['ap_Time'], $ap['FK_OwnerUser_ID'], $ap['ap_Done'], $ap['ap_Location']);
        }
    }

    public function getAll($user = null, $filter = null)
    {

        // JOIN FÜR WELCHER USER WELCHES AB ANSEHEN KANN $sql = 'SELECT a.ap_name ,acc.a_id, uacc.FK_User_ID, u.u_name from tbl_activitypackage a INNER JOIN tbl_access acc ON a.ap_ID = acc.a_ID INNER JOIN tbl_user_access uacc ON uacc.FK_AccessU_ID = acc.a_ID INNER JOIN tbl_user u ON uacc.FK_User_ID = u.u_ID';
        $apsFin = [];
        $aps = [];

        $db = Database::connect();

        if($filter == null)
        {
            if($user == null){
                $sql = 'SELECT * FROM tbl_Activitypackage ORDER BY ap_Date DESC';
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            else{
                $sql = 'SELECT * FROM tbl_Activitypackage Inner join tbl_Access a on a.FK_Activitypackage_ID = tbl_Activitypackage.ap_ID Inner join tbl_User_Access ua on ua.FK_AccessU_ID = a.a_ID Where FK_OwnerUser_ID = ? OR ua.FK_User_ID = ? ORDER BY ap_Date DESC';
                $stmt = $db->prepare($sql);
                $stmt->execute(array($user->getId(), $user->getId()));
            }
            $aps = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            if($user == null){
                $sql = 'SELECT * FROM tbl_Activitypackage ORDER BY ap_Date DESC';
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            else {
                if (preg_match_all('^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}^', $filter) == 1) {
                    $sql = 'SELECT * FROM tbl_Activitypackage Inner join tbl_Access a on a.FK_Activitypackage_ID = tbl_Activitypackage.ap_ID Inner join tbl_User_Access ua on ua.FK_AccessU_ID = a.a_ID Where (FK_OwnerUser_ID = ? OR ua.FK_User_ID = ?) AND ap_Date LIKE ? ORDER BY ap_Date DESC';
                    $stmt = $db->prepare($sql);
                    $stmt->execute(array($user->getId(), $user->getId(), $filter));
                }
                else if (preg_match_all('^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}^', $filter) == 2)
                {
                    $sql = 'SELECT * FROM tbl_Activitypackage Inner join tbl_Access a on a.FK_Activitypackage_ID = tbl_Activitypackage.ap_ID Inner join tbl_User_Access ua on ua.FK_AccessU_ID = a.a_ID Where (FK_OwnerUser_ID = ? OR ua.FK_User_ID = ?) AND ap_Date BETWEEN ? AND ? ORDER BY ap_Date DESC';
                    $stmt = $db->prepare($sql);
                    $date1 = substr($filter, 0, strpos($filter, ","));
                    $date2 = substr($filter, strpos($filter,",")+1);
                    $stmt->execute(array($user->getId(), $user->getId(), $date1, $date2));
                }
                else
                {
                    $sql = 'SELECT * FROM tbl_Activitypackage Inner join tbl_Access a on a.FK_Activitypackage_ID = tbl_Activitypackage.ap_ID Inner join tbl_User_Access ua on ua.FK_AccessU_ID = a.a_ID Where (FK_OwnerUser_ID = ? OR ua.FK_User_ID = ?) AND (ap_Name LIKE ? OR ap_Note LIKE ? OR ap_Location LIKE ? OR ap_Street LIKE ?) ORDER BY ap_Date DESC';
                    $stmt = $db->prepare($sql);
                    $stmt->execute(array($user->getId(), $user->getId(), '%'.$filter.'%', '%'.$filter.'%', '%'.$filter.'%', '%'.$filter.'%'));
                }
                $aps = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        Database::disconnect();

        foreach ($aps as $ap) {
            $apsFin[] = new ActivityPackage($ap['ap_ID'], $ap['ap_Name'], $ap['ap_Note'], $ap['ap_Street'], $ap['ap_StreetNr'], $ap['ap_Date'], $ap['ap_Time'], $ap['FK_OwnerUser_ID'], $ap['ap_Done'], $ap['ap_Location']);
        }
        return $apsFin;

    }

    public static function delete($id)
    {
        $db = Database::connect();
        $sql = 'DELETE FROM tbl_Activitypackage WHERE ap_ID =?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        Database::disconnect();
    }

    public function update()
    {
        $db = Database::connect();
        $sql = 'UPDATE tbl_Activitypackage SET ap_Note=?, ap_Street=?, ap_StreetNr=?, ap_Date=?, ap_Time=?, fk_ownerUser_ID=?, ap_Done=?, ap_Location WHERE ap_ID=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->note, $this->street, $this->streetNr, $this->date, $this->time, $this->fkOwner,$this->done,$this->location, $this->id));
        Database::disconnect();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getStreetNr()
    {
        return $this->streetNr;
    }

    /**
     * @param mixed $streetNr
     */
    public function setStreetNr($streetNr)
    {
        $this->streetNr = $streetNr;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getFkOwner()
    {
        return $this->fkOwner;
    }

    /**
     * @param mixed $fkOwner
     */
    public function setFkOwner($fkOwner)
    {
        $this->fkOwner = $fkOwner;
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
     * @return int
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * @param int $done
     */
    public function setDone($done)
    {
        $this->done = $done;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function jsonSerialize()
    {
        return
        [
          "ap_ID" => $this->getId(),
            "ap_Name" => $this->getName(),
            "ap_Location" =>$this->getLocation(),
            "ap_Note" => $this->getNote(),
            "ap_Street" =>$this->getStreet(),
            "ap_StreetNr" =>$this->getStreetNr(),
            "ap_Date" => $this->getDate(),
            "ap_Time" =>$this->getTime(),
            "ap_Done" =>$this->getDone(),
            "ap_OwnerUser" => $this->getFkOwner()
        ];
    }

}