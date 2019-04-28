<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 26/04/2019
 * Time: 19:08
 */

use PHPUnit\Framework\TestCase;

require 'Product.php';

class ProductTest extends TestCase
{
    /**
     * @covers Product::isValid
     */
    public function testisValid() {
        $user = new User("test@test.fr", "test", "boris", 20);
        $product = new Product("object1", $user);
        $result = $product->isValid();
        $this->assertTrue($result);
    }

    /**
     * @covers Product::isValid
     */
    public function testisNotValidBecauseName() {
        $user = new User("test@test.fr", "test", "boris", 20);
        $product = new Product("", $user);
        $result = $product->isValid();
        $this->assertFalse($result);
    }

    /**
     * @covers Product::isValid
     */
    public function testisNotValidBecauseUser() {
        $user = new User("test@test.fr", "test", "boris", 6);
        $product = new Product("object2", $user);
        $result = $product->isValid();
        $this->assertFalse($result);
    }
}
