<?php

namespace AppBundle\Repository;


use AppBundle\Converter\GithubClient\BaseRepositoryStatisticsConverter;
use AppBundle\Converter\GithubClient\RepositoryPullRequestConverter;
use AppBundle\Converter\GithubClient\RepositoryReleaseConverter;
use AppBundle\Entity\BaseRepositoryStatistics;
use AppBundle\Entity\RepositoryPullRequest;
use AppBundle\Entity\RepositoryRelease;
use AppBundle\Repository\Exception\NotFoundException;

class GithubRepository implements SubversionRepository
{
    /**
     * @var \Github\Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new \Github\Client();
    }

    public function fetchRepositoryBaseStatistics($repositoryName): BaseRepositoryStatistics
    {
        list($owner, $projectName) = explode('/', $repositoryName);

        try {
            /** @var \Github\Api\Repo $apiRepo */
            $apiRepo = $this->client->repository();
            $repositoryDetails = $apiRepo->show($owner, $projectName);

            $converter = new BaseRepositoryStatisticsConverter();
            return $converter->convert($repositoryDetails);
        } catch (\Github\Exception\ApiLimitExceedException $e) {
            $this->handleApiLimitException();
        } catch (\Github\Exception\RuntimeException $e) {
            return $this->handleException($e, $repositoryName);
        }
    }

    public function countOpenPullRequests($repositoryName): int
    {
        return $this->countPullRequestsCount($repositoryName, 'open');
    }

    public function countClosedPullRequestsCount($repositoryName): int
    {
        return $this->countPullRequestsCount($repositoryName, 'closed');
    }

    public function countPullRequestsCount($repositoryName, $status): int
    {
        list($owner, $projectName) = explode('/', $repositoryName);

        try {
            $apiRepo = $this->client->pullRequests();
            $paginator = new \Github\ResultPager($this->client);
            $parameters = [$owner, $projectName, ['state' => $status, 'per_page' => 1]];
            $result = $paginator->fetch($apiRepo, 'all', $parameters);
            $pagination = $paginator->getPagination();
        } catch (\Github\Exception\ApiLimitExceedException $e) {
            $this->handleApiLimitException();
        }

        if (!$pagination) {
            return count($result);
        }

        $urlParsed = parse_url($pagination['last']);
        parse_str($urlParsed['query'], $queriesParams);
        return (int)$queriesParams['page'];
    }

    public function fetchLastMergedPullRequest($repositoryName): RepositoryPullRequest
    {
        list($owner, $projectName) = explode('/', $repositoryName);

        try {
            $apiRepo = $this->client->pullRequests();
            $paginator = new \Github\ResultPager($this->client);
            $parameters = [$owner, $projectName, ['state' => 'closed', 'per_page' => 30]];
            $result = $paginator->fetch($apiRepo, 'all', $parameters);
        } catch (\Github\Exception\ApiLimitExceedException $e) {
            $this->handleApiLimitException();
        }

        $converter = new RepositoryPullRequestConverter();

        do {
            foreach ($result as $pullRequest) {
                if ($pullRequest['merged_at']) {
                    return $converter->convert($pullRequest);
                }
            }
            $result = $paginator->fetchNext();
        } while ($paginator->hasNext());

        throw new NotFoundException("Not Found merged pull request for repo: {$repositoryName}");
    }

    public function fetchLastRelease($repositoryName): RepositoryRelease
    {
        list($owner, $projectName) = explode('/', $repositoryName);

        try {
            $apiRepo = $this->client->repository()->releases()->setPerPage(1);
            $releases = $apiRepo->all($owner, $projectName);
        } catch (\Github\Exception\ApiLimitExceedException $e) {
            $this->handleApiLimitException();
        }

        if (count($releases) == 0) {
            throw new NotFoundException("Not Found release for repo: {$repositoryName}");
        }

        $release = $releases[0];
        $converter = new RepositoryReleaseConverter();
        return $converter->convert($release);

    }

    /**
     * @param \Exception $e
     * @param string $repositoryName
     * @throws NotFoundException
     */
    private function handleException($e, $repositoryName)
    {
        if ($e->getMessage() == 'Not Found') {
            throw new NotFoundException("Not Found {$repositoryName}");
        } else {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function handleApiLimitException(): void
    {
        throw new \RuntimeException("You have reached GitHub hourly limit! Please try later.");
    }
}