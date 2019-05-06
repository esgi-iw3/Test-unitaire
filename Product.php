<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 26/04/2019
 * Time: 18:56
 */

use PHPUnit\Framework\TestCase;

require 'User.php';

class Product
{
    private $name;
    private $owner;

    /**
     * Product constructor.
     * @param $name
     * @param $owner
     */
    public function __construct($name, $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
    }

    public function isValid()
    {
        return !empty($this->name)
            && isset($this->owner)
            && $this->owner->isValid();
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
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     * @return Product
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

}