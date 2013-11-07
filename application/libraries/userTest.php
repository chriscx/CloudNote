<?php
 
class userTest extends PHPUnit_Framework_TestCase
{
    private $CI;
 
    public function setUp()
    {
        $this->CI = &get_instance();
        //$this->CI->load->database('testing');
    }
 
    public function testGetsAllPosts()
    {
        $this->CI->load->model('user');
        $user = $this->CI->user->user();
        $this->assertEquals(1, count($user));
    }
}