<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 01/05/2019
 * Time: 21:14
 */

use PHPUnit\Framework\TestCase;

require 'Product.php';
require 'User.php';
require 'Exchange.php';
require 'DBConnection.php';
require 'EmailSender.php';

class ExchangeTest extends TestCase
{

    private $exchange;

    //A FINIR

    protected function setUp(): void
    {
        $mockedReceiver = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedReceiver->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $mockedOwner = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $mockedProduct = $this->createMock(Product::class, array('isValid'), array(null, $mockedOwner));
        $mockedProduct->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->exchange = new Exchange($mockedReceiver, $mockedProduct, $mockedOwner, "09-05-2019", "20-05-2019");

    }

    protected function tearDown(): void
    {
        $this->exchange = NULL;
    }
}
