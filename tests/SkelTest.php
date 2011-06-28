<?php
require 'src/Skel.php';

use skel\Skel;

class ModelMock extends Skel{
    protected $name = 'snit';
    protected $age = 25;
    protected $address;
    protected $nameWithMagicGet = 'snit';

    function __getNameWithMagicGet(){
        return strtoupper( $this->nameWithMagicGet );
    }
}

class SkelTest extends PHPUnit_Framework_TestCase{
    function test_skel_class_exists(){
        $this->assertTrue( class_exists('skel\Skel') );
    }

    function test_magic_get_can_return_value(){
        $modelMock = new ModelMock();

        $this->assertEquals( 'snit', $modelMock->name );
    }

    function test_magic_get_can_return_null_attribute(){
        $modelMock = new ModelMock();

        $this->assertNull( $modelMock->address );
    }

    function test_magic_get_does_not_fail_with_inexistent_attribute(){
        $modelMock = new ModelMock();

        $this->assertNull( $modelMock->inexistent_attribute );
    }

    function test_magic_get_can_call_user_defined_magic_getter(){
        $modelMock = new ModelMock();

        $this->assertEquals( 'SNIT', $modelMock->nameWithMagicGet );
    }
}