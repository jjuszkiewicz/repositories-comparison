Installation
============

**Requiers:**
 * PHP 7.1
 * Redist - optional


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
    
Website you can see on [localhost:8000](http://localhost:8000)

API documentation
-----------------

Document API is on address:
    
    http://localhost:8000/api/doc
    
    
Run tests
---------

TO run test make command:

    vendor/phpunit/phpunit/phpunit
 