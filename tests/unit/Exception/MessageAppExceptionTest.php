<?php
namespace MessageApp\Test\Exception;

use Faker\Factory;
use MessageApp\Exception\MessageAppException;

class MessageAppExceptionTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $message;

    public function setUp()
    {
        $this->message = Factory::create()->sentence;
    }

    /**
     * @test
     */
    public function itShouldBuildTheException()
    {
        $exception = new MessageAppException($this->message);

        $this->assertEquals($this->message, $exception->getMessage());
    }
}
