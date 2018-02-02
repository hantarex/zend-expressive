<?php

namespace Mongo;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ODM\MongoDB\Tools\Console\Command;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use DoctrineMongoODMModule\Logging;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Service\EntityResolverFactory;
use Helderjs\Component\DoctrineMongoODM\ConfigurationFactory;
use Helderjs\Component\DoctrineMongoODM\ConnectionFactory;
use Helderjs\Component\DoctrineMongoODM\DocumentManagerFactory;
use Helderjs\Component\DoctrineMongoODM\EventManagerFactory;
use Mongo\Service\Delegators\EntityManagerDelegatorFactory;
use Mongo\Service\Delegators\RegisterAnnotationMongoDelegatorFactory;
use Mongo\Action\TestMongoAction;
use Mongo\Action\TestMongoActionFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
            'doctrine' => $this->getDoctrine(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
//        return [
//            'factories' => [
//                MongoDBService::class => MongoDBServiceFactory::class,
//                TestMongoAction::class => TestMongoActionFactory::class,
//            ]
//        ];
        return [
            'invokables' => [
                'doctrine.odm_default.cache' => \Doctrine\Common\Cache\ArrayCache::class,
            ],
            'aliases' => [
                'Configuration' => 'config',
            ],
            'factories' => [
                'doctrine.cli' => 'DoctrineModule\Service\CliFactory',
                'doctrine.configuration.odm_default' => new ConfigurationFactory('odm_default'),
                'doctrine.connection.odm_default' => new ConnectionFactory('odm_default'),
                'doctrine.eventmanager.odm_default' => new EventManagerFactory('odm_default'),
                'doctrine.documentmanager.odm_default' => DocumentManagerFactory::class,
                \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
//                \Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
//                \Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
                'doctrine.driver.odm_default' => new \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory('odm_default'),
                MappingDriverChain::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,

                'doctrine.connection.mysql_master' => new DBALConnectionFactory('mysql_master'),
                'doctrine.entitymanager.mysql_master' => new EntityManagerFactory('mysql_master'),
                'doctrine.configuration.mysql_master' => new \DoctrineORMModule\Service\ConfigurationFactory('mysql_master'),
                'doctrine.eventmanager.mysql_master' => new CommonService\EventManagerFactory('mysql_master'),
                'doctrine.entity_resolver.mysql_master' => new EntityResolverFactory('mysql_master'),
                'doctrine.driver.mysql_master' => new CommonService\DriverFactory('mysql_master'),
                'doctrine.cache.array' => new CommonService\CacheFactory('array'),

                TestMongoAction::class => TestMongoActionFactory::class,
            ],
            'delegators' => [
                MappingDriverChain::class => [
                    RegisterAnnotationMongoDelegatorFactory::class
                ],
                'doctrine.driver.mysql_master' => [
                    EntityManagerDelegatorFactory::class
                ]
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app' => [__DIR__ . '/../templates/mongo'],
                'error' => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }

    private function getDoctrine()
    {
        return [
            'driver' => [
                'odm_default' => [
                    \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::class => [
                        'documents_dir' => [__DIR__."/Entity"]
                    ],
                ]
            ]
        ];
    }
}
