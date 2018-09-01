<?php

declare(strict_types=1);

namespace Doctrine\Website\Tests\Projects;

use Doctrine\Website\Projects\ProjectFactory;
use Doctrine\Website\Projects\ProjectJsonReader;
use Doctrine\Website\Projects\ProjectRepository;
use PHPUnit\Framework\TestCase;

class ProjectRepositoryTest extends TestCase
{
    /** @var string[][] */
    private $projects = [
        [
            'name' => 'ORM',
            'slug' => 'orm',
            'docsSlug' => 'doctrine-orm',
            'repositoryName' => 'doctrine2',
        ],
        [
            'name' => 'DBAL',
            'slug' => 'dbal',
            'docsSlug' => 'doctrine-dbal',
            'repositoryName' => 'dbal',
        ],
    ];

    /** @var ProjectJsonReader */
    private $projectJsonReader;

    /** @var ProjectFactory */
    private $projectFactory;

    /** @var ProjectRepository */
    private $projectRepository;

    protected function setUp() : void
    {
        $this->projectJsonReader = $this->createMock(ProjectJsonReader::class);
        $this->projectFactory    = new ProjectFactory($this->projectJsonReader);
        $this->projectRepository = new ProjectRepository($this->projects, $this->projectFactory);
    }

    public function testFindOneBySlug() : void
    {
        $orm = $this->projectRepository->findOneBySlug('orm');

        self::assertSame('ORM', $orm->getName());

        $orm = $this->projectRepository->findOneBySlug('doctrine-orm');

        self::assertSame('ORM', $orm->getName());

        $dbal = $this->projectRepository->findOneBySlug('dbal');

        self::assertSame('DBAL', $dbal->getName());

        $dbal = $this->projectRepository->findOneBySlug('doctrine-dbal');

        self::assertSame('DBAL', $dbal->getName());
    }

    public function testFindAll() : void
    {
        self::assertCount(2, $this->projectRepository->findAll());
    }
}