<?php

use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ODM\MongoDB\Configuration;
use DoctrineORMModule\Service\DoctrineObjectHydratorFactory;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;


return [
    'mongo' => [
        'connection' => [
            'server'           => '127.0.0.1',
            'port'             => '27017',
            'database'             => 'sportdepo',
            'connectionString' => null,
            'user'             => null,
            'password'         => null,
            'dbname'           => null,
            'options'          => []
        ],
    ],
    'doctrine' => [
        'default' => 'odm_default',
        'connection' => [
            'odm_default' => [
                'server'           => '127.0.0.1',
                'port'             => '27017',
                'user'             => '',
                'password'         => '',
                'dbname'           => 'sportdepo',
                'options'          => []
            ],
            'mysql_master' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host'     => '127.0.0.1',
                    'user'     => 'root',
                    'password' => '256450',
                    'dbname'   => 'favor',
                    'charset'  => 'utf8',
                ]
            ],
        ],
        'driver' => [
            'odm_default' => [
                \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::class => [
                ],
//                \Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver::class => [
//                    'simplified' => false,
//                    'xml_dir' => [
//                        '/path/to/files1',
//                        '/path/to/files2',
//                    ]
//                ],
//                \Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver::class => [
//                    'simplified' => false,
//                    'yml_dir' => [
//                        '/path/to/files1',
//                        '/path/to/files2',
//                    ]
//                ],
                \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class => [
                    'Driver\Annotation' => \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::class,
                ],
            ],
            'banners_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../../src/Mongo/src/Entity')
            ),
            'mysql_master' => array(
                'drivers' => array(
                    'Banners' => 'banners_entity',
                )
            )
        ],
        'configuration' => [
            'odm_default' => [
                'metadata_cache'     => \Doctrine\Common\Cache\ArrayCache::class, // optional
                'driver'             => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'generate_proxies'   => true,
                'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',
                'generate_hydrators' => true,
                'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
                'default_db'         => 'sportdepo',
                'filters'            => [], // custom filters (optional)
                'types'              => [], // custom types (optional)
                'retry_connect'      => 0, // optional
                'retry_query'        => 0, // optional
                'classMetadataFactoryName' => 'stdClass'
            ],
                'mysql_master' => array(
                    'string_functions' => array(
                    )
                )
        ],
        'documentmanager' => [
            'odm_default' => [
                'connection'    => \Doctrine\MongoDB\Connection::class,
                'configuration' => \Doctrine\ODM\MongoDB\Configuration::class,
                'eventmanager'  => \Doctrine\Common\EventManager::class,
            ],
            'odm_secondary' => [
                'connection'    => 'doctrine.connection.secondary',
                'configuration' => \Doctrine\ODM\MongoDB\Configuration::class,
                'eventmanager'  => 'doctrine.eventmanager.secondary',
            ]
        ],
        'eventmanager' => [
            'odm_default' => [
                'subscribers' => [

                ],
            ],
            'odm_secondary' => [
                'subscribers' => [

                ],
            ],
        ],
    ],
];
