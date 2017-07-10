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

        $countClosedPullRequest = $this->subversionRepository->countOpenPullRequests($repositoryNameFirst);
        $firstRepositoryStatistics->setOpenPullRequestsCount($countClosedPullRequest);
        $countClosedPullRequest = $this->subversionRepository->countOpenPullRequests($repositoryNameSecond);
        $secondRepositoryStatistics->setOpenPullRequestsCount($countClosedPullRequest);

        try {
            $lastRelease = $this->subversionRepository->fetchLastRelease($repositoryNameFirst);
            $firstRepositoryStatistics->setLastRelease($lastRelease->getPublishedAt());
        } catch (NotFoundException $e) {
        }
        try {
            $lastRelease = $this->subversionRepository->fetchLastRelease($repositoryNameSecond);
            $secondRepositoryStatistics->setLastRelease($lastRelease->getPublishedAt());
        } catch (NotFoundException $e) {
        }

        return [$firstRepositoryStatistics, $secondRepositoryStatistics];
    }

    private function convertToRepositoryStatistics(BaseRepositoryStatistics $baseRepositoryStatistics)
    {
        $repositoryStatistics = new RepositoryStatistics();
        $repositoryStatistics->setName($baseRepositoryStatistics->getName());
        $repositoryStatistics->setLastUpdate($baseRepositoryStatistics->getLastUpdate());
        $repositoryStatistics->setWatchersCount($baseRepositoryStatistics->getWatchersCount());
        $repositoryStatistics->setStarsCount($baseRepositoryStatistics->getStarsCount());
        $repositoryStatistics->setForksCount($baseRepositoryStatistics->getForksCount());
        return$repositoryStatistics;
    }


}