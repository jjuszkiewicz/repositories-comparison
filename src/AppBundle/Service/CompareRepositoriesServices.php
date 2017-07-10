<?php

namespace AppBundle\Service;

use AppBundle\Entity\BaseRepositoryStatistics;
use AppBundle\Entity\RepositoryStatistics;
use AppBundle\Repository\Exception\NotFoundException;
use AppBundle\Repository\SubversionRepository;

class CompareRepositoriesServices
{
    /**
     * @var SubversionRepository
     */
    private $subversionRepository;

    public function __construct(SubversionRepository $subversionRepository)
    {
        $this->subversionRepository = $subversionRepository;
    }

    /**
     * @param string $repositoryNameFirst
     * @param string $repositoryNameSecond
     * @return \AppBundle\Entity\RepositoryStatistics[]|array
     */
    public function compare($repositoryNameFirst, $repositoryNameSecond)
    {
        $baseRepositoryStatistics = $this->subversionRepository->fetchRepositoryBaseStatistics($repositoryNameFirst);
        $firstRepositoryStatistics = $this->convertToRepositoryStatistics($baseRepositoryStatistics);
        $baseRepositoryStatistics = $this->subversionRepository->fetchRepositoryBaseStatistics($repositoryNameSecond);
        $secondRepositoryStatistics = $this->convertToRepositoryStatistics($baseRepositoryStatistics);

        $countClosedPullRequest = $this->subversionRepository->countClosedPullRequestsCount($repositoryNameFirst);
        $firstRepositoryStatistics->setClosedPullRequestsCount($countClosedPullRequest);
        $countClosedPullRequest = $this->subversionRepository->countClosedPullRequestsCount($repositoryNameSecond);
        $secondRepositoryStatistics->setClosedPullRequestsCount($countClosedPullRequest);

        $countOpenPullRequest = $this->subversionRepository->countOpenPullRequests($repositoryNameFirst);
        $firstRepositoryStatistics->setOpenPullRequestsCount($countOpenPullRequest);
        $countOpenPullRequest = $this->subversionRepository->countOpenPullRequests($repositoryNameSecond);
        $secondRepositoryStatistics->setOpenPullRequestsCount($countOpenPullRequest);

        $this->setLastRelease($firstRepositoryStatistics, $secondRepositoryStatistics);
        $this->setLastMeredPullRequest($firstRepositoryStatistics, $secondRepositoryStatistics);

        return [$firstRepositoryStatistics, $secondRepositoryStatistics];
    }

    private function convertToRepositoryStatistics(BaseRepositoryStatistics $baseRepositoryStatistics): RepositoryStatistics
    {
        $repositoryStatistics = new RepositoryStatistics();
        $repositoryStatistics->setName($baseRepositoryStatistics->getName());
        $repositoryStatistics->setLastUpdate($baseRepositoryStatistics->getLastUpdate());
        $repositoryStatistics->setWatchersCount($baseRepositoryStatistics->getWatchersCount());
        $repositoryStatistics->setStarsCount($baseRepositoryStatistics->getStarsCount());
        $repositoryStatistics->setForksCount($baseRepositoryStatistics->getForksCount());
        return $repositoryStatistics;
    }

    /**
     * @param RepositoryStatistics $firstRepositoryStatistics
     * @param RepositoryStatistics $secondRepositoryStatistics
     */
    private function setLastRelease(RepositoryStatistics $firstRepositoryStatistics, RepositoryStatistics $secondRepositoryStatistics): void
    {
        try {
            $lastRelease = $this->subversionRepository->fetchLastRelease($firstRepositoryStatistics->getName());
            $firstRepositoryStatistics->setLastRelease($lastRelease->getPublishedAt());
        } catch (NotFoundException $e) {
        }
        try {
            $lastRelease = $this->subversionRepository->fetchLastRelease($secondRepositoryStatistics->getName());
            $secondRepositoryStatistics->setLastRelease($lastRelease->getPublishedAt());
        } catch (NotFoundException $e) {
        }
    }

    /**
     * @param RepositoryStatistics $firstRepositoryStatistics
     * @param RepositoryStatistics $secondRepositoryStatistics
     */
    private function setLastMeredPullRequest(RepositoryStatistics $firstRepositoryStatistics, RepositoryStatistics $secondRepositoryStatistics): void
    {
        try {
            $lastMergedPullRequest = $this->subversionRepository->fetchLastMergedPullRequest($firstRepositoryStatistics->getName());
            $firstRepositoryStatistics->setLastMergedPullRequest($lastMergedPullRequest->getMergedAt());
        } catch (NotFoundException $e) {
        }
        try {
            $lastMergedPullRequest = $this->subversionRepository->fetchLastMergedPullRequest($secondRepositoryStatistics->getName());
            $secondRepositoryStatistics->setLastMergedPullRequest($lastMergedPullRequest->getMergedAt());
        } catch (NotFoundException $e) {
        }
    }

}