<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 31.01.2018
 * Time: 13:39
 */

namespace Mongo\Service;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class MongoDBServiceFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $applicationConfig = $container->has('config') ? $container->get('config') : [];
        $mongoConfig = array_key_exists('mongo', $applicationConfig) ? $applicationConfig['mongo'] : [];
        $mongoDB=new MongoDBDriver($mongoConfig);
        
        return new MongoDBService($mongoDB->getDatabase());
        // TODO: Implement __invoke() method.
    }
}