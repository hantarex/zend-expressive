<?php

namespace Mongo;
use Doctrine\ORM\EntityManager;
use DoctrineORMModule\Service\EntityManagerFactory;
use Mongo\Action\TestMongoAction;
use Mongo\Action\TestMongoActionFactory;
use VasilDakov\Doctrine\Container\DoctrineFactory;

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
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'factories'  => [
//                EntityManager::class => DoctrineFactory::class,
                EntityManager::class => \ContainerInteropDoctrine\EntityManagerFactory::class,
                TestMongoAction::class => TestMongoActionFactory::class,
//                \Doctrine\Common\Cache\Cache::class => \VasilDakov\Doctrine\Container\DoctrineRedisCacheFactory::class,
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
                'app'    => [__DIR__ . '/../templates/mongo'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
