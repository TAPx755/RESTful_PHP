<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-05-07
 * Time: 22:21
 */

class Privilege implements JsonSerializable
{
    private $id;
    private $name;
    private $description;
    private $read;
    private $write;
    private $grantUser;
    private $deleteUser;

    /**
     * Privilege constructor.
     * @param $privilege
     * @param $name
     * @param $description
     * @param $read
     * @param $write
     * @param $grantUser
     * @param $deleteUser
     */
    public function __construct($id, $name, $description, $read, $write, $grantUser, $deleteUser)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->read = $read;
        $this->write = $write;
        $this->grantUser = $grantUser;
        $this->deleteUser = $deleteUser;
    }

    public function getId()
    {
        return $this->id;
    }

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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * @param mixed $read
     */
    public function setRead($read): void
    {
        $this->read = $read;
    }

    /**
     * @return mixed
     */
    public function getWrite()
    {
        return $this->write;
    }

    /**
     * @param mixed $write
     */
    public function setWrite($write): void
    {
        $this->write = $write;
    }

    /**
     * @return mixed
     */
    public function getGrantUser()
    {
        return $this->grantUser;
    }

    /**
     * @param mixed $grantUser
     */
    public function setGrantUser($grantUser): void
    {
        $this->grantUser = $grantUser;
    }

    /**
     * @return mixed
     */
    public function getDeleteUser()
    {
        return $this->deleteUser;
    }

    /**
     * @param mixed $deleteUser
     */
    public function setDeleteUser($deleteUser): void
    {
        $this->deleteUser = $deleteUser;
    }


    public function jsonSerialize()
    {
        return
            [
                "p_ID" => $this->getId(),
                "p_Name" => $this->getName(),
                "p_Description" => $this->getDescription(),
                "p_Read" => $this->getRead(),
                "p_Write" => $this->getWrite(),
                "p_GrantUser" => $this->getGrantUser(),
                "p_DeleteUser" => $this->getDeleteUser()
             ];
    }

}