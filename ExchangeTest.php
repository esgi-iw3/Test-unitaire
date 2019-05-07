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

    //A FINIR

    protected function setUp(): void
    {
        $this->mockedReceiver = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $this->mockedReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));
        $this->mockedReceiver->expects($this->any())->method('isMinor')->will($this->returnValue(false));

        $this->mockedOwner = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $this->mockedOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));


        $this->makeEmailSender = $this->createMock(EmailSender::class,array('sendEmail'), array(null, null));
        $this->makeEmailSender->expects($this->any())->method('sendEmail')->will($this->returnSelf(true));

        $this->makeConnexion = $this->createMock(DatabaseConnection::class,array('saveExchange'), array(null));
        $this->makeConnexion->expects($this->any())->method('saveExchange')->will($this->returnSelf(true));

        $this->mockedProduct = $this->createMock(Product::class, array('isValid'), array(null, $this->mockedOwner));
        $this->mockedProduct->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->dateStart = new DateTime("2019-05-08");
        $this->dateEnd= new DateTime("2019-05-20");
        $this->saveExchange();
    }

    protected function tearDown(): void
    {
        $this->exchange = NULL;
    }
    
    public function saveExchange()
    {
        $this->exchange = new Exchange($this->mockedReceiver, $this->mockedProduct, $this->dateStart, $this->dateEnd, $this->makeEmailSender,$this->makeConnexion);
    }

    public function testSaveProductNotValid()
    {
        $this->makeProduct->method('isValid')->willReturn(false);
        $this->saveExchange();
        $this->assertFalse( $this->exchange->isValid());

    }

    public function testSaveReceiverValid()
    {
        $this->mockedReceiver->method('isValid')->willReturn(false);
        $this->saveExchange();
        $this->assertFalse( $this->exchange->isValid());

    }

    public function testSaveOwnerValid()
    {
        $this->mockedOwner->method('isValid')->willReturn(false);
        $this->mockedProduct->setOwner($this->mockedOwner);
        $this->saveExchange();
        $this->assertFalse( $this->exchange->isValid());

    }

    public function testSaveWehnSaveExchangeWork()
    {
        $this->assertFalse( $this->exchange->save());
    }

    public function testSaveWehnSaveExchangeNoWork()
    {
        $this->makeConnexion->expects($this->any())->method('saveExchange')->will($this->returnSelf(false));
        
        $this->saveExchange();
        $this->assertFalse( $this->exchange->save());
    }

    public function testSaveWhenReceiverIsMinorMailWillSend()
    {
        $this->mockedReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));
        $this->mockedReceiver->expects($this->any())->method('isMinor')->will($this->returnValue(true));

        $this->saveExchange();
        $this->assertFalse( $this->exchange->save());

    }

    public function testSaveWhenReceiverIsMinorMailWillNotSend()
    {
        $this->mockedReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));
        $this->mockedReceiver->expects($this->any())->method('isMinor')->will($this->returnValue(true));
        $this->makeEmailSender = $this->createMock(EmailSender::class,array('sendEmail'), array(null, null));
        $this->makeEmailSender->expects($this->any())->method('sendEmail')->will($this->returnSelf(false));

        $this->saveExchange();
        $this->assertFalse( $this->exchange->save());

    }


}
