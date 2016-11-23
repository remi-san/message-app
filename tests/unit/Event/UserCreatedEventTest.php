<?php
namespace MessageApp\Test\Event;

use Faker\Factory;
use MessageApp\Event\UserCreatedEvent;
use MessageApp\User\ApplicationUserId;

class UserCreatedEventTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApplicationUserId */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $language;

    public function setUp()
    {
        $faker = Factory::create();

        $this->id = new ApplicationUserId($faker->uuid);
        $this->username = $faker->userName;
        $this->language = $faker->countryISOAlpha3;
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldCreateTheEvent()
    {
        $event = new UserCreatedEvent($this->id, $this->username, $this->language);

        $this->assertEquals($this->id, $event->getUserId());
        $this->assertEquals($this->username, $event->getUsername());
        $this->assertEquals($this->language, $event->getPreferredLanguage());
    }
}
