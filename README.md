[![Build Status](https://travis-ci.org/jjuszkiewicz/repositories-comparison.svg?branch=master)](https://travis-ci.org/jjuszkiewicz/repositories-comparison)

Installation
============

**Requiers:**
 * PHP >=7.0
 * Redist - optional (cache) 
 * production adres: [http://87.98.235.58](http://87.98.235.58)


Clone repository:

    git clone git@github.com:jjuszkiewicz/repositories-comparison.git
    
Go to project dir and [Download Composer](https://getcomposer.org/download/)
    
    php composer.phar install
    
On the end of composer install task program ask you about parameters, if you want use cache please fill below params otherside keep default values:

    cache_redis_enabled: true
    cache_redis_host: <redis_host>
    cache_redis_port: <redis_port>

Run development server:
    
    php bin/console server:run
    
Website you can see on [localhost:8000](http://localhost:8000) or this project is on address: [http://87.98.235.58](http://87.98.235.58)

API documentation
-----------------

Document API is on address:
    
Localhost:

    http://localhost:8000/api/doc
    
Production:

    http://87.98.235.58/api/doc
    
    
Run tests
---------

To run test make command in project dir:

    ./vendor/phpunit/phpunit/phpunit
 