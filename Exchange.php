<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 01/05/2019
 * Time: 21:14
 */

require 'DBConnection.php';
require 'EmailSender.php';
require 'User.php';
require 'Product.php';

class Exchange
{

    private $receiver, $product, $owner, $dateDebut = '', $dateFin = '',
            $email, $database, $emailSender;

    /**
     * Exchange constructor.
     * @param $receiver
     * @param $product
     * @param $owner
     * @param $dateDebut
     * @param $dateFin
     * @param $email
     */
    public function __construct($receiver, $product, $owner, $dateDebut, $dateFin, $email)
    {
        $this->receiver = $receiver;
        $this->product = $product;
        $this->owner = $owner;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->email = $email;
        $this->database = new DBConnection();
        $this->emailSender = new EmailSender();
    }

    public function isValid()
    {
        return isset($this->owner) && isset($this->receiver) && isset($this->product)
                && $this->owner->isValid() && $this->receiver->isValid() && $this->product->isValid()
                && validateDate($this->dateDebut)  && $this->dateDebut >  date('d-m-Y')
                && validateDate($this->dateFin) && $this->dateFin > $this->dateDebut;
    }


    public function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function save(){

    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
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
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
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
    public function setEmail($email): void
    {
        $this->email = $email;
    }

}