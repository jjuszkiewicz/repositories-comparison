<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\BaseRepositoryStatistics;
use AppBundle\Entity\RepositoryPullRequest;
use AppBundle\Entity\RepositoryRelease;
use AppBundle\Entity\RepositoryStatistics;
use AppBundle\Service\CompareRepositoriesServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CompareRepositoriesServicesTest extends KernelTestCase
{

    const REPO_NAME_1 = 'test/test1';
    const REPO_NAME_2 = 'test/test2';
    private $baseRepositoryStatisticsRepo1;
    private $baseRepositoryStatisticsRepo2;
    private $lastReleaseRepo1;
    private $lastReleaseRepo2;
    private $lastLastMergedPullRequestRepo1;
    private $closedPullRepo1 = 10;
    private $closedPullRepo2 = 3;
    private $openPullRepo1 = 1;
    private $openPullRepo2 = 0;

    public function testCompare()
    {
        $this->baseRepositoryStatisticsRepo1 = $this->prepareBaseRepositoryStatistics(self::REPO_NAME_1);
        $this->baseRepositoryStatisticsRepo2 = $this->prepareBaseRepositoryStatistics(self::REPO_NAME_2);
        $this->lastReleaseRepo1 = $this->prepareLastRelease(self::REPO_NAME_1);
        $this->lastReleaseRepo2 = $this->prepareLastRelease(self::REPO_NAME_2);
        $this->lastLastMergedPullRequestRepo1 = $this->prepareLastMergedPullRequest(self::REPO_NAME_1);
        $subversionRepository = $this->createMock(
            '\AppBundle\Repository\SubversionRepository',
            ['fetchRepositoryBaseStatistics', 'countClosedPullRequestsCount', 'countOpenPullRequests', 'fetchLastRelease', 'fetchLastMergedPullRequest']
        );

        $subversionRepository->method('fetchRepositoryBaseStatistics')
            ->will($this->returnCallback([$this, 'callbackFetchRepositoryBaseStatistics']));
        $subversionRepository->method('countClosedPullRequestsCount')
            ->will($this->returnCallback([$this, 'callbackCountClosedPullRequestsCount']));
        $subversionRepository->expects($this->any())->method('countOpenPullRequests')
            ->will($this->returnCallback([$this, 'callbackCountOpenPullRequests']));
        $subversionRepository->expects($this->any())->method('fetchLastRelease')
            ->will($this->returnCallback([$this, 'callbackFetchLastRelease']));
        $subversionRepository->expects($this->any())->method('fetchLastMergedPullRequest')
            ->will($this->returnCallback([$this, 'callbackFetchLastMergedPullRequest']));

        $cut = new CompareRepositoriesServices($subversionRepository);

        $result = $cut->compare(self::REPO_NAME_1, self::REPO_NAME_2);
        $this->assertCount(2, $result);

        /** @var RepositoryStatistics $statisticsRepo1 */
        $statisticsRepo1 = $result[0];
        /** @var RepositoryStatistics $statisticsRepo2 */
        $statisticsRepo2 = $result[1];

        $this->assertEquals($this->closedPullRepo1, $statisticsRepo1->getClosedPullRequestsCount());
        $this->assertEquals($this->openPullRepo1, $statisticsRepo1->getOpenPullRequestsCount());
        $this->assertEquals($this->lastLastMergedPullRequestRepo1->getMergedAt(), $statisticsRepo1->getLastMergedPullRequest());
        $this->assertEquals($this->lastReleaseRepo1->getPublishedAt(), $statisticsRepo1->getLastRelease());
        $this->assertEquals($this->baseRepositoryStatisticsRepo1->getForksCount(), $statisticsRepo1->getForksCount());
        $this->assertEquals($this->baseRepositoryStatisticsRepo1->getLastUpdate(), $statisticsRepo1->getLastUpdate());
        $this->assertEquals($this->baseRepositoryStatisticsRepo1->getName(), $statisticsRepo1->getName());
        $this->assertEquals($this->baseRepositoryStatisticsRepo1->getStarsCount(), $statisticsRepo1->getStarsCount());
        $this->assertEquals($this->baseRepositoryStatisticsRepo1->getWatchersCount(), $statisticsRepo1->getWatchersCount());

        $this->assertEquals($this->closedPullRepo2, $statisticsRepo2->getClosedPullRequestsCount());
        $this->assertEquals($this->openPullRepo2, $statisticsRepo2->getOpenPullRequestsCount());
        $this->assertNull($statisticsRepo2->getLastMergedPullRequest());
        $this->assertEquals($this->lastReleaseRepo2->getPublishedAt(), $statisticsRepo2->getLastRelease());
        $this->assertEquals($this->baseRepositoryStatisticsRepo2->getForksCount(), $statisticsRepo2->getForksCount());
        $this->assertEquals($this->baseRepositoryStatisticsRepo2->getLastUpdate(), $statisticsRepo2->getLastUpdate());
        $this->assertEquals($this->baseRepositoryStatisticsRepo2->getName(), $statisticsRepo2->getName());
        $this->assertEquals($this->baseRepositoryStatisticsRepo2->getStarsCount(), $statisticsRepo2->getStarsCount());
        $this->assertEquals($this->baseRepositoryStatisticsRepo2->getWatchersCount(), $statisticsRepo2->getWatchersCount());
    }

    public function callbackFetchRepositoryBaseStatistics()
    {
        $args = func_get_args();
        if ($args[0] == self::REPO_NAME_1) {
            return $this->baseRepositoryStatisticsRepo1;
        }
        if ($args[0] == self::REPO_NAME_2) {
            return $this->baseRepositoryStatisticsRepo2;
        }
        throw new \InvalidArgumentException('unsupported argument: ' . $args[0]);
    }

    public function callbackCountClosedPullRequestsCount()
    {
        $args = func_get_args();
        if ($args[0] == self::REPO_NAME_1) {
            return $this->closedPullRepo1;
        }
        if ($args[0] == self::REPO_NAME_2) {
            return $this->closedPullRepo2;
        }
        throw new \InvalidArgumentException('unsupported argument: ' . $args[0]);
    }

    public function callbackCountOpenPullRequests()
    {
        $args = func_get_args();
        if ($args[0] == self::REPO_NAME_1) {
            return $this->openPullRepo1;
        }
        if ($args[0] == self::REPO_NAME_2) {
            return $this->openPullRepo2;
        }
        throw new \InvalidArgumentException('unsupported argument: ' . $args[0]);
    }

    public function callbackFetchLastRelease()
    {
        $args = func_get_args();
        if ($args[0] == self::REPO_NAME_1) {
            return $this->lastReleaseRepo1;
        }
        if ($args[0] == self::REPO_NAME_2) {
            return $this->lastReleaseRepo2;
        }
        throw new \InvalidArgumentException('unsupported argument: ' . $args[0]);
    }

    public function callbackFetchLastMergedPullRequest()
    {
        $args = func_get_args();
        if ($args[0] == self::REPO_NAME_1) {
            return $this->lastLastMergedPullRequestRepo1;
        }
        if ($args[0] == self::REPO_NAME_2) {
            throw new \AppBundle\Repository\Exception\NotFoundException();
        }
        throw new \InvalidArgumentException('unsupported argument: ' . $args[0]);
    }

    private function prepareBaseRepositoryStatistics($repositoryName): BaseRepositoryStatistics
    {
        $baseRepositoryStatistics = new BaseRepositoryStatistics();
        $baseRepositoryStatistics->setName($repositoryName);
        $baseRepositoryStatistics->setForksCount(rand(0, 100));
        $baseRepositoryStatistics->setWatchersCount(rand(0, 100));
        $baseRepositoryStatistics->setStarsCount(rand(0, 100));
        $baseRepositoryStatistics->setLastUpdate(new \DateTime());
        return $baseRepositoryStatistics;
    }

    private function prepareLastRelease($repositoryName): RepositoryRelease
    {
        $randDays = rand(0, 10);
        $lastRelease = new RepositoryRelease();
        $lastRelease->setId($repositoryName);
        $daysAgoCreateAt = $randDays - 10;
        $lastRelease->setCreatedAt(new \DateTime("-{$daysAgoCreateAt} day"));
        $lastRelease->setPublishedAt(new \DateTime("-{$randDays} day"));
        $lastRelease->setTagName('tag-' . $repositoryName);
        return $lastRelease;
    }

    private function prepareLastMergedPullRequest($repositoryName): RepositoryPullRequest
    {
        $randDays = rand(0, 10);
        $lastLastMergedPullRequest = new RepositoryPullRequest();
        $lastLastMergedPullRequest->setId($repositoryName);
        $daysAgoCreateAt = $randDays - 10;
        $lastLastMergedPullRequest->setCreatedAt(new \DateTime("-{$daysAgoCreateAt} day"));
        $lastLastMergedPullRequest->setMergedAt(new \DateTime("-{$randDays} day"));
        $lastLastMergedPullRequest->setUpdatedAt(new \DateTime("-{$randDays} day"));
        $lastLastMergedPullRequest->setTitle('merge-' . $repositoryName);
        $lastLastMergedPullRequest->setState('closed');
        $lastLastMergedPullRequest->setNumber($randDays);
        return $lastLastMergedPullRequest;
    }

}
