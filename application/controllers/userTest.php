<?php
    
class userTest extends PHPUnit_Framework_TestCase
{
    private $CI;

    public function setUp() {
        $this->CI = &get_instance();
    }

    public function testPushAndPop()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));
 
        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));
 
        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
    
    public function testCreate() {

    }
    
    public function testLogIn(){
        
    }
    
    public function testIsLoggedIn(){
        
    }
    
    public function testLogOut(){
        
    }
    
    public function testgetListOfNotes(){

    }
    
    public function testGetNote() {

    }
}
?>