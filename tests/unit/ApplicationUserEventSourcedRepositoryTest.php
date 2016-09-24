<?php

namespace MessageApp\Test;

use Broadway\Domain\AggregateRoot;
use Broadway\EventSourcing\EventSourcingRepository;
use MessageApp\Test\Mock\AggregateRootApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Repository\EventSourced\ApplicationUserEventSourcedRepository;

class ApplicationUserEventSourcedRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventSourcingRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = \Mockery::mock(EventSourcingRepository::class);
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
        $user = \Mockery::mock(SourcedUser::class);

        $repository = new ApplicationUserEventSourcedRepository($this->repository);

        $this->repository->shouldReceive('save')->with($user);

        $repository->save($user);
    }

    /**
     * @test
     */
    public function itShouldUseTheInnerRepositoryToLoadTheUser()
    {
        $userId = \Mockery::mock(ApplicationUserId::class);
        $user = \Mockery::mock(SourcedUser::class);

        $repository = new ApplicationUserEventSourcedRepository($this->repository);

        $this->repository->shouldReceive('load')->with($userId)->andReturn($user);

        $returnUser = $repository->load($userId);

        $this->assertEquals($returnUser, $user);
    }

    /**
     * @test
     */
    public function itShouldReturnNullIfTheInnerRepositoryReturnsNull()
    {
        $userId = \Mockery::mock(ApplicationUserId::class);

        $repository = new ApplicationUserEventSourcedRepository($this->repository);

        $this->repository->shouldReceive('load')->with($userId)->andReturn(null);

        $this->assertNull($repository->load($userId));
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfTheLoadedEntityIsNotAnApplicationUser()
    {
        $userId = \Mockery::mock(ApplicationUserId::class);
        $user = \Mockery::mock(AggregateRoot::class);

        $repository = new ApplicationUserEventSourcedRepository($this->repository);

        $this->repository->shouldReceive('load')->with($userId)->andReturn($user);
        $this->setExpectedException(\InvalidArgumentException::class);

        $repository->load($userId);
    }
}
