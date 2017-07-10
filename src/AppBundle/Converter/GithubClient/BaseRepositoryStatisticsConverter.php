<?php
namespace AppBundle\Converter\GithubClient;

use AppBundle\Converter\ConverterInterface;
use AppBundle\Entity\BaseRepositoryStatistics;

class BaseRepositoryStatisticsConverter implements ConverterInterface
{
    /**
     * @param $object
     * @return BaseRepositoryStatistics
     */
    public function convert($object)
    {
        $baseRepositoryStatistics = new BaseRepositoryStatistics();
        $baseRepositoryStatistics->setName($object['full_name']);
        $baseRepositoryStatistics->setForksCount($object['forks_count']);
        $baseRepositoryStatistics->setStarsCount($object['stargazers_count']);
        $baseRepositoryStatistics->setWatchersCount($object['subscribers_count']);
        $baseRepositoryStatistics->setLastUpdate(new \DateTime($object['updated_at']));

        return $baseRepositoryStatistics;
    }

}