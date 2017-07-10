<?php

namespace AppBundle\Entity;


class RepositoryPullRequest
{
    private $id;
    /**
     * @var int
     */
    private $number;
    /**
     * @var string
     */
    private $state;
    /**
     * @var string
     */
    private $title;
    /**
     * @var \DateTime
     */
    private $createdAt;
    /**
     * @var \DateTime
     */
    private $updatedAt;
    /**
     * @var \DateTime
     */
    private $closedAt;
    /**
     * @var \DateTime
     */
    private $mergedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt(): \DateTime
    {
        return $this->closedAt;
    }

    /**
     * @param \DateTime $closedAt
     */
    public function setClosedAt(\DateTime $closedAt)
    {
        $this->closedAt = $closedAt;
    }

    /**
     * @return \DateTime
     */
    public function getMergedAt(): \DateTime
    {
        return $this->mergedAt;
    }

    /**
     * @param \DateTime $mergedAt
     */
    public function setMergedAt(\DateTime $mergedAt)
    {
        $this->mergedAt = $mergedAt;
    }


}