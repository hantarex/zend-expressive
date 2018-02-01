<?php

namespace Mongo;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Tools\Console\Command;
use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use DoctrineMongoODMModule\Logging;
use Helderjs\Component\DoctrineMongoODM\ConfigurationFactory;
use Helderjs\Component\DoctrineMongoODM\ConnectionFactory;
use Helderjs\Component\DoctrineMongoODM\DocumentManagerFactory;
use Helderjs\Component\DoctrineMongoODM\EventManagerFactory;
use Mongo\Service\MongoDBService;
use Mongo\Service\MongoDBServiceFactory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
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
                \Doctrine\Common\Cache\ArrayCache::class => \Doctrine\Common\Cache\ArrayCache::class,
            ],
            'factories' => [
                \Doctrine\ODM\MongoDB\Configuration::class => ConfigurationFactory::class,
                Connection::class => ConnectionFactory::class,
                EventManager::class => EventManagerFactory::class,
                \Doctrine\ODM\MongoDB\DocumentManager::class => DocumentManagerFactory::class,
//                'doctrine.connection.secondary'              => new ConnectionFactory('odm_secondary'),
//                'doctrine.eventmanager.secondary'            => new EventManagerFactory('odm_secondary'),
//                'doctrine.documentmandager.secondary'        => new DocumentManagerFactory('odm_secondary'),
                \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
                \Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
                \Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
                MappingDriverChain::class => \Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory::class,
                TestMongoAction::class => TestMongoActionFactory::class,
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
