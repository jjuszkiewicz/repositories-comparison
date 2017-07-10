<?php


namespace AppBundle\Converter\GithubClient;


use AppBundle\Converter\ConverterInterface;
use AppBundle\Entity\RepositoryRelease;

class RepositoryReleaseConverter implements ConverterInterface
{
    public function convert($object)
    {
        $repositoryRelease = new RepositoryRelease();
        $repositoryRelease->setCreatedAt(new \DateTime($object['created_at']));
        $repositoryRelease->setPublishedAt(new \DateTime($object['published_at']));
        $repositoryRelease->setId($object['id']);
        $repositoryRelease->setTagName($object['tag_name']);
        return $repositoryRelease;
    }

}