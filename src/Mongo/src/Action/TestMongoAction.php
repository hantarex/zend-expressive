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
//        var_dump($this->db->getRepository(Products::class)->findBy([
//            'brand'=>'NIKE'
//        ]));
//          var_dump(count($this->db->getRepository(Products::class)->findBy([])));
//          var_dump($this->db->createQueryBuilder(Products::class)->find()->getQuery()->execute());

//        $resultCursor=$this->db->createQueryBuilder(Products::class)->find()->getQuery()->execute();
//        var_dump($resultCursor);
//        $i=0;
//        foreach ($resultCursor as $test){
//            var_dump($test);
//            $i++;
//            if($i>10) break;
//        }

        $builder = $this->db->createAggregationBuilder(Products::class);
        $builder
            ->match()
                ->addAnd(
                    [
                        "category" => 22690,
                    ],
                    $builder->matchExpr()->addOr(
                        [
                            "brand"=>"MIZUNO"
                        ]
//                        [
//                            "brand"=>"PUMA"
//                        ]
                    )
                )
            ->facet()
                ->field("brands")
                    ->pipeline(
                        $this->db->createAggregationBuilder(Products::class)->group()
                            ->field('_id')
                            ->expression(
                                $builder->expr()
                                    ->field('brand')
                                    ->expression('$brand')
                                    ->field('url')
                                    ->expression('$url_code')
                            )
                            ->field('count')
                            ->sum(1)
                        ->group()
                            ->field('_id')
                            ->expression('$_id.brand')
                            ->field('count')
                            ->sum(1)
                    );

        print_r($builder->execute()->toArray());

        echo "ok";
        // TODO: Implement process() method.
    }
}