<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 26/04/2019
 * Time: 18:17
 */

use PHPUnit\Framework\TestCase;

require 'User.php';

class UserTest extends TestCase
{

    public function testIsValid()
    {
        $user = new User("test@test.fr", "toto", "toto", 20);
        $result = $user->isValid();
        $this->assertTrue($result);
    }

    public function testisNoValidBecauseEmailFormat(){
        $user = new User("test.fr", "toto", "toto", 20);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

    public function testIsNoValidBecauseToYoung(){
        $user = new User("test@test.fr", "toto", "toto", 9);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

    public function testIsNoActiveBecauseFirstnameIsInvalid(){
        $user = new User("test.fr", "toto", "", 20);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

}
