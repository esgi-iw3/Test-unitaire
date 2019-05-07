<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 01/05/2019
 * Time: 21:14
 */

require_once('User.php');
require_once('Product.php');
require_once ('DBConnection.php');
require_once ('EmailSender.php');

class Exchange
{

    private $receiver, $product, $dateDebut, $dateFin,
            $database, $emailSender;

    /**
     * Exchange constructor.
     * @param $receiver
     * @param $product
     * @param $dateDebut
     * @param $dateFin
     * @param $emailSender
     * @param $database
     */
    public function __construct($receiver, $product,  $dateDebut, $dateFin, $emailSender, $database)
    {
        $this->receiver = $receiver;
        $this->product = $product;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->database = $database;
        $this->emailSender = $emailSender;
    }

    public function isValid()
    {
        return  isset($this->receiver) && isset($this->product)
                && $this->receiver->isValid() && $this->product->isValid()
                && $this->dateDebut instanceof DateTime && $this->dateFin instanceof DateTime
                && $this->dateDebut > date('Y-m-d') && $this->dateFin->getTimestamp() > $this->dateDebut->getTimestamp();
                //&& $this->dateFin > $this->dateDebut;
    }


    /*public function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }*/

    /*public function save(){
        if($this->isValid())
        {
            if($this->receiver->isMinor()){
                $emailReceiver = $this->receiver->getEmail();
                $messageContent = "Vous ne pouvez pas enregistrer l'exchange, vous n'êtes pas majeur";
    
                $this->emailSender->sendEmail($emailReceiver, $messageContent);
    
            } else {
                $this->database->saveExchange($this);
            }
        }
    }*/

    public function save()
    {
        if ($this->isValid()) {
            if ($this->receiver->getAge() < 18) {
                $emailReceiver = $this->receiver->getEmail();
                $messageContent = "Vous ne pouvez pas enregistrer l'exchange, vous n'êtes pas majeur";

                $this->emailSender->sendEmail($emailReceiver, $messageContent);

            } else {
                $this->database->saveExchange($this);
            }
        }
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
}