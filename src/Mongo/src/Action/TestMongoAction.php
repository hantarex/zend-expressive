<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 30.01.2018
 * Time: 16:52
 */

namespace Mongo\Action;


use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManager;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Mongo\Entity\Products;
use Mongo\Service\MongoDBService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestMongoAction implements MiddlewareInterface
{
    /**
     * TestMongoAction constructor.
     * @param MongoDBService $db
     */
    public function __construct(DocumentManager $db)
    {
        $this->db=$db;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
//        var_dump($this->db->getRepository(Products::class));
        var_dump($this->db->getRepository(Products::class));
        echo "ok";
        // TODO: Implement process() method.
    }
}