<?php


namespace Tests\AppBundle\Converter\GithubClient;

use AppBundle\Converter\GithubClient\RepositoryReleaseConverter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryReleaseConverterTest extends KernelTestCase
{
    public function testConvert()
    {
        $cut = new RepositoryReleaseConverter();
        $object = $this->getFixture('repo-release');

        $repositoryRelease = $cut->convert($object);

        $this->assertEquals(new \DateTime($object['created_at']), $repositoryRelease->getCreatedAt());
        $this->assertEquals(new \DateTime($object['published_at']), $repositoryRelease->getPublishedAt());
        $this->assertEquals($object['id'], $repositoryRelease->getId());

    }

    private function getFixture($fileName)
    {
        $content = file_get_contents(__DIR__ . '/../../../Fixtures/' . $fileName . '.json');
        return json_decode($content, true);
    }
}