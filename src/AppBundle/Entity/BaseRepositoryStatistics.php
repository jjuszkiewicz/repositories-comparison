<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class BaseRepositoryStatistics
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $name;
    /**
     * @JMS\Type("integer")
     *
     * @var int
     */
    protected $forksCount;
    /**
     * @JMS\Type("integer")
     *
     * @var int
     */
    protected $starsCount;
    /**
     * @JMS\Type("integer")
     *
     * @var int
     */
    protected $watchersCount;
    /**
     * @JMS\Type("DateTime")
     *
     * @var \DateTime
     */
    protected $lastUpdate;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getForksCount(): int
    {
        return $this->forksCount;
    }

    /**
     * @param int $forksCount
     */
    public function setForksCount(int $forksCount)
    {
        $this->forksCount = $forksCount;
    }

    /**
     * @return int
     */
    public function getStarsCount(): int
    {
        return $this->starsCount;
    }

    /**
     * @param int $starsCount
     */
    public function setStarsCount(int $starsCount)
    {
        $this->starsCount = $starsCount;
    }

    /**
     * @return int
     */
    public function getWatchersCount(): int
    {
        return $this->watchersCount;
    }

    /**
     * @param int $watchersCount
     */
    public function setWatchersCount(int $watchersCount)
    {
        $this->watchersCount = $watchersCount;
    }


    /**
     * @return \DateTime
     */
    public function getLastUpdate(): \DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime $lastUpdate
     */
    public function setLastUpdate(\DateTime $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

}