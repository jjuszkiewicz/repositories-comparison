<?php

namespace Tests\AppBundle\Converter\GithubClient;

use AppBundle\Converter\GithubClient\RepositoryPullRequestConverter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RespositoryPullRequestConverterTest extends KernelTestCase
{
    public function testConvert()
    {
        $cut = new RepositoryPullRequestConverter();
        $object = $this->getFixture('pull-request');

        $repositoryPullRequest = $cut->convert($object);

        $this->assertEquals($object['id'], $repositoryPullRequest->getId());
        $this->assertEquals($object['number'], $repositoryPullRequest->getNumber());
        $this->assertEquals($object['state'], $repositoryPullRequest->getState());
        $this->assertEquals($object['title'], $repositoryPullRequest->getTitle());
        $this->assertEquals(new \DateTime($object['created_at']), $repositoryPullRequest->getCreatedAt());
        $this->assertEquals(new \DateTime($object['updated_at']), $repositoryPullRequest->getUpdatedAt());
        $this->assertEquals(new \DateTime($object['closed_at']), $repositoryPullRequest->getClosedAt());
        $this->assertEquals(new \DateTime($object['merged_at']), $repositoryPullRequest->getMergedAt());
    }

    private function getFixture($fileName)
    {
        $content = file_get_contents(__DIR__ . '/../../../Fixtures/' . $fileName . '.json');
        return json_decode($content, true);
    }
}