<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 01/05/2019
 * Time: 21:14
 */

use PHPUnit\Framework\TestCase;

require_once('Product.php');
require_once('User.php');
require_once('Exchange.php');
require_once('DBConnection.php');
require_once('EmailSender.php');

class ExchangeTest extends TestCase
{
    private $exchange;
    private $dateDebut;
    private $dateFin;
    private $mockedReceiver;
    private $mockedOwner;
    private $mockedProduct;
    private $mockedEmailSender;
    private $mockedConnexion;

    public function testSave(){
        $result = $this->exchange->save();
        $this->assertTrue($result);
    }

    public function testSaveProductNotValid()
    {
        $mockedProductNotValid = $this->createMock(Product::class, array('isValid'), array(null, null));
        $mockedProductNotValid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->exchange->setProduct($mockedProductNotValid);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveReceiverNotValid()
    {
        $mockedReceiverNotValid = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedReceiverNotValid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->exchange->setReceiver($mockedReceiverNotValid);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveOwnerNotValid()
    {
        $mockedOwnerNotValid = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedOwnerNotValid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->mockedProduct->setOwner($mockedOwnerNotValid);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveDateDebutNotValid(){
        $dateDebutNotValid = "test";

        $this->exchange->setDateDebut($dateDebutNotValid);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveDateFinNotValid(){
        $dateFinNotValid = "test2";

        $this->exchange->setDateFin($dateFinNotValid);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveDateDebutNotValidBecauseLowerDateNow()
    {
        $dateDebutNotValidBecauseLowerDateNow = new DateTime("2019-01-01");

        $this->exchange->setDateDebut($dateDebutNotValidBecauseLowerDateNow);
        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveDateDebutNotValidBecauseGreaterDateFin()
    {
        $dateDebutNotValidBecauseGreaterDateFin = new DateTime("2019-05-25");
        $dateFinNotValidBecauseLowerDateDebut = new DateTime("2019-05-20");

        $this->exchange->setDateDebut($dateDebutNotValidBecauseGreaterDateFin);
        $this->exchange->setDatFin($dateFinNotValidBecauseLowerDateDebut);

        $result = $this->exchange->isValid();
        $this->assertFalse($result);
    }

    public function testSaveWhenSaveExchangeNotWorkBecauseDBConnection()
    {
        $this->mockedConnexion = $this->createMock(DBConnection::class, array('saveExchange'), array(null));
        $this->mockedConnexion->expects($this->any())->method('saveExchange')->will($this->returnSelf(false));

        $this->saveExchange();

        $result = $this->exchange->save();
        $this->assertFalse($result);
    }

    public function testSaveWhenReceiverIsMinorMailWillSend()
    {
        $mockedReceiverMinor = $this->createMock(User::class, array('isValid'), array(null, null, null, 15));
        $mockedReceiverMinor->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->mockedReceiver->setReceiver($mockedReceiverMinor);
        $result = $this->exchange->save();
        $this->assertTrue($result);
    }

    public function testSaveWhenReceiverIsNotMinorMailWillNotSend()
    {
        $mockedReceiverNotMinor = $this->createMock(User::class, array('isValid'), array(null, null, null, 25));
        $mockedReceiverNotMinor->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->mockedReceiver->setReceiver($mockedReceiverNotMinor);
        $result = $this->exchange->save();
        $this->assertFalse($result);
    }

    public function testSaveWhenReceiverIsMinorMailWillSendButEmailSenderNotWork()
    {
        $this->mockedReceiver = $this->createMock(User::class, array('isValid'), array(null, null, null, 15));
        $this->mockedReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));


        $this->mockedEmailSender = $this->createMock(EmailSender::class, array('sendEmail'), array(null, null));
        $this->mockedEmailSender->expects($this->any())->method('sendEmail')->will($this->returnSelf(false));

        $this->saveExchange();
        $result = $this->exchange->save();
        $this->assertFalse($result);
    }

    /**
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        $mockedReceiver = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));
        //$this->mockedReceiver->expects($this->any())->method('isMinor')->will($this->returnValue(false));

        $mockedOwner = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $mockedProduct = $this->createMock(Product::class, array('isValid'), array(null, $this->mockedOwner));
        $mockedProduct->expects($this->any())->method('isValid')->will($this->returnValue(true));

        //renvoie une référence à l'objet stubbed
        $mockedEmailSender = $this->createMock(EmailSender::class, array('sendEmail'), array(null, null));
        $mockedEmailSender->expects($this->any())->method('sendEmail')->will($this->returnSelf(true));

        $mockedConnexion = $this->createMock(DBConnection::class, array('saveExchange'), array(null));
        $mockedConnexion->expects($this->any())->method('saveExchange')->will($this->returnSelf(true));

        $this->dateDebut = new DateTime("2019-05-09");
        $this->dateFin= new DateTime("2019-05-20");

        $this->exchange = new Exchange($this->mockedReceiver, $this->mockedProduct, $this->dateDebut, $this->dateFin, $this->mockedEmailSender, $this->mockedConnexion);

    }

    public function saveExchange()
    {
        $this->exchange = new Exchange($this->mockedReceiver, $this->mockedProduct, $this->dateDebut, $this->dateFin, $this->mockedEmailSender,$this->mockedConnexion);
    }

    protected function tearDown(): void
    {
        $this->exchange = NULL;
    }

}
