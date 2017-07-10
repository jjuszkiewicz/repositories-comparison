<?php

namespace AppBundle\Converter\GithubClient;


use AppBundle\Converter\ConverterInterface;
use AppBundle\Entity\RepositoryPullRequest;

class RepositoryPullRequestConverter implements ConverterInterface
{
    public function convert($object)
    {
        $repositoryPullRequest = new RepositoryPullRequest();
        $repositoryPullRequest->setId($object['id']);
        $repositoryPullRequest->setNumber($object['number']);
        $repositoryPullRequest->setState($object['state']);
        $repositoryPullRequest->setTitle($object['title']);
        $repositoryPullRequest->setCreatedAt(new \DateTime($object['created_at']));
        $repositoryPullRequest->setUpdatedAt(new \DateTime($object['updated_at']));
        $repositoryPullRequest->setClosedAt(new \DateTime($object['closed_at']));
        $repositoryPullRequest->setMergedAt(new \DateTime($object['merged_at']));

        return $repositoryPullRequest;
    }
}