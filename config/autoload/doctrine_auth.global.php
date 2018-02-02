<?php

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ODM\MongoDB\Configuration;
use DoctrineORMModule\Service\DoctrineObjectHydratorFactory;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;


return [
    'doctrine' => [
        'connection' => [
            'odm_default' => [
                'server' => '127.0.0.1',
                'port' => '27017',
                'user' => '',
                'password' => '',
                'dbname' => 'sportdepo',
                'options' => []
            ],
            'mysql_master' => [
                'configuration'=>'mysql_master',
                'eventmanager'=>'mysql_master',
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host' => '127.0.0.1',
                    'user' => 'root',
                    'password' => '256450',
                    'dbname' => 'favor',
                    'charset' => 'utf8',
                ]
            ],
        ],
        'driver' => [
            'odm_default' => [
                \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class => [
                    'Driver\Annotation' => \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::class,
                ],
            ],
            'banners_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../../src/Mongo/src/Entity')
            ),
            'mysql_master' => array(
                    // By default, the ORM module uses a driver chain. This allows multiple
                    // modules to define their own entities
                    'class'   => MappingDriverChain::class,

                    // Map of driver names to be used within this driver chain, indexed by
                    // entity namespace
                    'drivers' => [
                        'Mongo' => 'banners_entity',
                    ],
            )
        ],
        'configuration' => [
            'odm_default' => [
                'metadata_cache' => \Doctrine\Common\Cache\ArrayCache::class, // optional
                'driver' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'generate_proxies' => true,
                'proxy_dir' => 'data/DoctrineMongoODMModule/Proxy',
                'proxy_namespace' => 'DoctrineMongoODMModule\Proxy',
                'generate_hydrators' => true,
                'hydrator_dir' => 'data/DoctrineMongoODMModule/Hydrator',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
                'default_db' => 'sportdepo',
                'filters' => [], // custom filters (optional)
                'types' => [], // custom types (optional)
                'retry_connect' => 0, // optional
                'retry_query' => 0, // optional
                'classMetadataFactoryName' => 'stdClass'
            ],
            'mysql_master' => array(
                'string_functions' => array(),
                'driver'=>'mysql_master'
            )
        ],
        'cache' => array(
            'apc' => array(
                'class'     => 'Doctrine\Common\Cache\ApcCache',
                'namespace' => 'DoctrineModule',
            ),
            'apcu' => array(
                'class'     => 'Doctrine\Common\Cache\ApcuCache',
                'namespace' => 'DoctrineModule',
            ),
            'array' => array(
                'class' => 'Doctrine\Common\Cache\ArrayCache',
                'namespace' => 'DoctrineModule',
            ),
            'filesystem' => array(
                'class'     => 'Doctrine\Common\Cache\FilesystemCache',
                'directory' => 'data/DoctrineModule/cache',
                'namespace' => 'DoctrineModule',
            ),
            'memcache' => array(
                'class'     => 'Doctrine\Common\Cache\MemcacheCache',
                'instance'  => 'my_memcache_alias',
                'namespace' => 'DoctrineModule',
            ),
            'memcached' => array(
                'class'     => 'Doctrine\Common\Cache\MemcachedCache',
                'instance'  => 'my_memcached_alias',
                'namespace' => 'DoctrineModule',
            ),
            'predis' => array(
                'class'     => 'Doctrine\Common\Cache\PredisCache',
                'instance'  => 'my_predis_alias',
                'namespace' => 'DoctrineModule',
            ),
            'redis' => array(
                'class'     => 'Doctrine\Common\Cache\RedisCache',
                'instance'  => 'my_redis_alias',
                'namespace' => 'DoctrineModule',
            ),
            'wincache' => array(
                'class'     => 'Doctrine\Common\Cache\WinCacheCache',
                'namespace' => 'DoctrineModule',
            ),
            'xcache' => array(
                'class'     => 'Doctrine\Common\Cache\XcacheCache',
                'namespace' => 'DoctrineModule',
            ),
            'zenddata' => array(
                'class'     => 'Doctrine\Common\Cache\ZendDataCache',
                'namespace' => 'DoctrineModule',
            ),
        ),
        'entity_resolver' => [
            'mysql_master' => [
                'eventManager' => 'mysql_master'
            ],
        ],
        'documentmanager' => [
            'odm_default' => [
                'connection' => 'doctrine.connection.odm_default',
                'configuration' => 'doctrine.configuration.odm_default',
                'eventmanager' => 'doctrine.eventmanager.odm_default',
            ],
        ],
        'eventmanager' => [
            'odm_default' => [
                'subscribers' => [

                ],
            ],
            'mysql_master' => [
                'subscribers' => [

                ],
            ],
        ],
        'entitymanager' => [
            'mysql_master' => [
                // connection instance to use. The retrieved service name will
                // be `doctrine.connection.$thisSetting`
                'connection' => 'mysql_master',

                // configuration instance to use. The retrieved service name will
                // be `doctrine.configuration.$thisSetting`
                'configuration' => 'mysql_master',
                'entityResolver' => 'mysql_master',
            ],
        ],
    ],
];
