<?php
namespace MessageApp\Test\Command;

use Faker\Factory;
use MessageApp\Command\CreateUserCommand;
use MessageApp\User\ApplicationUserId;
use RemiSan\Context\Context;
use Twitter\Object\TwitterUser;

class CreateUserCommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApplicationUserId */
    private $userId;

    /** @var TwitterUser */
    private $user;

    /** @var Context */
    private $context;

    /** @var string */
    private $language;

    public function setUp()
    {
        $faker = Factory::create();

        $this->userId  = new ApplicationUserId($faker->uuid);
        $this->user = \Mockery::mock(TwitterUser::class);
        $this->context = \Mockery::mock(Context::class);
        $this->language = $faker->countryISOAlpha3;
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldConstructTheCommand()
    {
        $command = CreateUserCommand::create($this->userId, $this->user, $this->language, $this->context);

        $this->assertEquals($this->userId, $command->getId());
        $this->assertEquals($this->user, $command->getOriginalUser());
        $this->assertEquals(CreateUserCommand::NAME, $command->getCommandName());
        $this->assertEquals($this->context, $command->getContext());
        $this->assertEquals($this->language, $command->getPreferredLanguage());
    }
}
