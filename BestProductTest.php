<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 01/05/2019
 * Time: 20:29
 */

use PHPUnit\Framework\TestCase;

require 'Product.php';
require 'User.php';


class BestProductTest extends TestCase
{
    private $product;

    public function testIsValid()
    {
        $mockedOwnerValid = $this->createMock(User::class, array('isValid'), array("toto@test.fr", "toto", "toto", 20));
        $mockedOwnerValid->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->product->setOwner($mockedOwnerValid);
        $result = $this->product->isValid();
        $this->assertTrue($result);
    }

    public function testIsNoValidOwnerIsNotValid()
    {
        $mockedOwnerNotValid = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedOwnerNotValid->expects($this->any())->method('isValid')->will($this->returnValue(false));

        $this->product->setOwner($mockedOwnerNotValid);
        $result = $this->product->isValid();
        $this->assertFalse($result);
    }

    protected function setUp(): void
    {
        $mockedOwner = $this->createMock(User::class, array('isValid'), array(null, null, null, null));
        $mockedOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));

        $this->product = new Product("object1", $mockedOwner);
    }

    protected function tearDown(): void
    {
        $this->product = NULL;
    }
}
