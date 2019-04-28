<?php

class User
{

    private $email;
    private $lastname;
    private $firstname;
    private $age;

    /**
     * User constructor.
     * @param $email
     * @param $lastname
     * @param $firstname
     * @param $age
     */
    public function __construct($email, $lastname, $firstname, $age)
    {
        $this->email = $email;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->age = $age;
    }

    function isValid(){
        return filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->firstname)
            && !empty($this->lastname)
            && is_int($this->age)
            && $this->age >= 13;
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
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {

        return $this->age;
    }

    /**
     * @param mixed $age
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }
}


