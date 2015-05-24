<?php
namespace MessageApp\Test;

use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\InMemoryUserManager;

class UserManager extends InMemoryUserManager {
    use MessageAppMocker;

    protected function getUserId($object)
    {
        return $object->getId();
    }

    public function createUser($object)
    {
        return $this->getApplicationUser(1, 'user');
    }

    protected function supports($object)
    {
        return true;
    }
}

class UserManagerTest extends \PHPUnit_Framework_TestCase {
    use MessageAppMocker;

    private $playerId = 1;
    private $playerName = 'user';

    private $user;

    public function setUp()
    {
        $this->user = $this->getApplicationUser($this->playerId, $this->playerName);
    }

    /**
     * @test
     */
    public function testSave() {

        $manager = new UserManager();
        $manager->saveUser($this->user);

        $this->assertEquals($this->user, $manager->getUser($this->user));
    }

    /**
     * @test
     */
    public function testCreate() {

        $manager = new UserManager();
        $manager->createUser($this->user);

        $this->assertEquals($this->playerId, $manager->getUser($this->user)->getId());
        $this->assertEquals($this->playerName, $manager->getUser($this->user)->getName());
    }

    /**
     * @test
     */
    public function testCreateWhenNotExisting() {

        $manager = new UserManager();
        $user = $manager->getUser($this->user);

        $this->assertEquals($this->playerId, $user->getId());
        $this->assertEquals($this->playerName, $user->getName());
    }
} 