<?php
namespace AppBundle\Repository;
use AppBundle\Entity\BaseRepositoryStatistics;
use AppBundle\Entity\RepositoryPullRequest;
use AppBundle\Entity\RepositoryRelease;

/**
 * Created by PhpStorm.
 * Date: 09.07.2017
 * Time: 23:29
 */
interface SubversionRepository
{
    public function fetchRepositoryBaseStatistics($repositoryName) :BaseRepositoryStatistics;
    public function countOpenPullRequests($repositoryName) :int;
    public function countClosedPullRequestsCount($repositoryName) :int;
    public function fetchLastMergedPullRequest($repositoryName) :RepositoryPullRequest;
    public function fetchLastRelease($repositoryName) :RepositoryRelease;

}