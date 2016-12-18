<?php

namespace MessageApp\Test\User\Repository\EventSourced;

use Broadway\Domain\AggregateRoot;
use Broadway\EventSourcing\EventSourcingRepository;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Repository\EventSourced\UserEventSourcedRepository;
use Mockery\Mock;

class ApplicationUserEventSourcedRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApplicationUserId */
    private $userId;

    /** @var SourcedUser */
    private $user;

    /** @var EventSourcingRepository | Mock */
    private $eventSourcingRepository;

    /** @var UserEventSourcedRepository */
    private $serviceUnderTest;

    public function setUp()
    {
        $this->userId = new ApplicationUserId(42);
        $this->user = \Mockery::mock(SourcedUser::class);

        $this->eventSourcingRepository = \Mockery::mock(EventSourcingRepository::class);

        $this->serviceUnderTest = new UserEventSourcedRepository($this->eventSourcingRepository);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldDeferSaveToInnerRepository()
    {
        $this->assertInnerRepositoryPersistsUser();

        $this->serviceUnderTest->save($this->user);
    }

    /**
     * @test
     */
    public function itShouldUseTheInnerRepositoryToLoadTheUser()
    {
        $this->givenInnerRepositoryReturnsAValidUser();

        $returnUser = $this->serviceUnderTest->load($this->userId);

        $this->assertEquals($returnUser, $this->user);
    }

    /**
     * @test
     */
    public function itShouldReturnNullIfTheInnerRepositoryReturnsNull()
    {
        $this->givenInnerRepositoryReturnsNothing();

        $this->assertNull($this->serviceUnderTest->load($this->userId));
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfTheLoadedEntityIsNotAnApplicationUser()
    {
        $this->givenInnerRepositoryReturnsAnInvalidUser();

        $this->setExpectedException(\InvalidArgumentException::class);

        $this->serviceUnderTest->load($this->userId);
    }

    private function assertInnerRepositoryPersistsUser()
    {
        $this->eventSourcingRepository->shouldReceive('save')->with($this->user)->once();
    }

    private function givenInnerRepositoryReturnsAValidUser()
    {
        $this->eventSourcingRepository->shouldReceive('load')->with($this->userId)->andReturn($this->user);
    }

    private function givenInnerRepositoryReturnsNothing()
    {
        $this->eventSourcingRepository->shouldReceive('load')->with($this->userId)->andReturn(null);
    }

    private function givenInnerRepositoryReturnsAnInvalidUser()
    {
        $this->user = \Mockery::mock(AggregateRoot::class);
        $this->eventSourcingRepository->shouldReceive('load')->with($this->userId)->andReturn($this->user);
    }
}
