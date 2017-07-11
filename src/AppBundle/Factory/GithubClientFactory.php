<?php

namespace AppBundle\Factory;


use Cache\Adapter\Redis\RedisCachePool;

class GithubClientFactory
{
    /**
     * @param bool $cacheEnabled
     * @param string $redisHost
     * @param int $redisPort
     * @return \Github\Client
     */
    public function newInstance(bool $cacheEnabled, $redisHost, $redisPort)
    {
        $client = new \Github\Client();
        if ($cacheEnabled) {
            $redisCache = new \Redis();
            $redisCache->connect($redisHost, $redisPort);
            $pool = new RedisCachePool($redisCache);
            $client->addCache($pool);
        }

        return $client;
    }
}