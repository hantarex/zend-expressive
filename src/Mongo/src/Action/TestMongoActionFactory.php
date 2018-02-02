<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 30.01.2018
 * Time: 16:54
 */

namespace Mongo\Action;


use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Mongo\Service\MongoDBService;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class TestMongoActionFactory implements FactoryInterface
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
//        $db=$container->get(MongoDBService::class);
//        return new TestMongoAction($db);
        $mongoDB=$container->get('doctrine.documentmanager.odm_default');
        $mysql=$container->get('doctrine.entitymanager.mysql_master');
//        $mysql=null;
//        $mongoDB = null;
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        
        return new TestMongoAction($mongoDB, $mysql, $template);
        // TODO: Implement __invoke() method.
    }
}