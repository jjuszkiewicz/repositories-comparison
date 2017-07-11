<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class RepositoryStatistics extends BaseRepositoryStatistics
{
    /**
     * @JMS\Type("integer")
     *
     * @var int
     */
    protected $openPullRequestsCount;
    /**
     * @JMS\Type("integer")
     *
     * @var int
     */
    protected $closedPullRequestsCount;
    /**
     * @JMS\Type("DateTime")
     *
     * @var \DateTime
     */
    protected $lastMergedPullRequest;
    /**
     * @JMS\Type("DateTime")
     *
     * @var \DateTime
     */
    protected $lastRelease;

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
    public function getLastMergedPullRequest()
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
    public function getLastRelease()
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