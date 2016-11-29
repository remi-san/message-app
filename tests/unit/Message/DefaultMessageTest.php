<?php
namespace MessageApp\Test\Message;

use Faker\Factory;
use MessageApp\Message\DefaultMessage;
use MessageApp\User\ApplicationUser;

class DefaultMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $message;

    /** @var ApplicationUser */
    private $user;

    public function setUp()
    {
        $faker = Factory::create();

        $this->message = $faker->sentence;
        $this->user = \Mockery::mock(ApplicationUser::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testSendMessage()
    {
        $response = new DefaultMessage([$this->user], $this->message);

        $this->assertEquals([$this->user], $response->getUsers());
        $this->assertEquals($this->message, $response->getMessage());
    }
}
