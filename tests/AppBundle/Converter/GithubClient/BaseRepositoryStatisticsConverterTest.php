<?php


namespace Tests\AppBundle\Converter\GithubClient;

use AppBundle\Converter\GithubClient\BaseRepositoryStatisticsConverter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseRepositoryStatisticsConverterTest extends KernelTestCase
{
    public function testConvert()
    {
        $cut = new BaseRepositoryStatisticsConverter();
        $object = $this->getFixture('repo-get');

        $result = $cut->convert($object);

        $this->assertEquals($object['full_name'], $result->getName());
        $this->assertEquals($object['forks_count'], $result->getForksCount());
        $this->assertEquals($object['stargazers_count'], $result->getStarsCount());
        $this->assertEquals($object['subscribers_count'], $result->getWatchersCount());
        $this->assertEquals(new \DateTime($object['updated_at']), $result->getLastUpdate());
    }

    private function getFixture($fileName)
    {
        $content = file_get_contents(__DIR__ . '/../../../Fixtures/' . $fileName . '.json');
        return json_decode($content, true);
    }
}