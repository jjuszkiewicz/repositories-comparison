<?php

namespace AppBundle\Entity;


class RepositoryStatistics extends BaseRepositoryStatistics
{
    /**
     * @var int
     */
    private $openPullRequestsCount;
    /**
     * @var int
     */
    private $closedPullRequestsCount;
    /**
     * @var \DateTime
     */
    private $lastMergedPullRequest;
    /**
     * @var \DateTime
     */
    private $lastRelease;

    /**
     * @return int
     */
    public function getOpenPullRequestsCount(): int
    {
        return $this->openPullRequestsCount;
    }

    /**
     * @param int $openPullRequestsCount
     */
    public function setOpenPullRequestsCount(int $openPullRequestsCount)
    {
        $this->openPullRequestsCount = $openPullRequestsCount;
    }

    /**
     * @return int
     */
    public function getClosedPullRequestsCount(): int
    {
        return $this->closedPullRequestsCount;
    }

    /**
     * @param int $closedPullRequestsCount
     */
    public function setClosedPullRequestsCount(int $closedPullRequestsCount)
    {
        $this->closedPullRequestsCount = $closedPullRequestsCount;
    }

    /**
     * @return \DateTime
     */
    public function getLastMergedPullRequest(): \DateTime
    {
        return $this->lastMergedPullRequest;
    }

    /**
     * @param \DateTime $lastMergedPullRequest
     */
    public function setLastMergedPullRequest(\DateTime $lastMergedPullRequest)
    {
        $this->lastMergedPullRequest = $lastMergedPullRequest;
    }

    /**
     * @return \DateTime
     */
    public function getLastRelease(): \DateTime
    {
        return $this->lastRelease;
    }

    /**
     * @param \DateTime $lastRelease
     */
    public function setLastRelease(\DateTime $lastRelease)
    {
        $this->lastRelease = $lastRelease;
    }
    
    
}