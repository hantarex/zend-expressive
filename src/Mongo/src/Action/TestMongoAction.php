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
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestMongoAction implements MiddlewareInterface
{
    protected $template;
    protected $mongoDB;
    private $mysql;

    /**
     * TestMongoAction constructor.
     * @param DocumentManager $mongoDB
     * @param EntityManager $mysql
     * @param TemplateRendererInterface|null $template
     */
    public function __construct(DocumentManager $mongoDB, EntityManager $mysql, TemplateRendererInterface $template = null)
    {
        $this->mongoDB=$mongoDB;
        $this->template = $template;
        $this->mysql=$mysql;
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


        $builder = $this->mongoDB->createAggregationBuilder(Products::class);
        $builder
            ->match()
                ->addAnd(
                    [
                        "category" => 22690,
                    ],
                    $builder->matchExpr()->addOr(
                        [
                            "brand"=>"MIZUNO"
                        ],
                        [
                            "brand"=>"PUMA"
                        ]
                    )
                )
            ->facet()
                ->field("brands")
                    ->pipeline(
                        $this->mongoDB->createAggregationBuilder(Products::class)->group()
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
                    )
                ->field("profs")
                ->pipeline(
                    $this->mongoDB->createAggregationBuilder(Products::class)->group()
                        ->field('_id')
                        ->expression(
                            $builder->expr()
                                ->field('prof')
                                ->expression('$prof')
                                ->field('url')
                                ->expression('$url_code')
                        )
                        ->field('count')
                        ->sum(1)
                        ->group()
                        ->field('_id')
                        ->expression('$_id.prof')
                        ->field('count')
                        ->sum(1)
                )
                ->field("size_rus")
                ->pipeline(
                    $this->mongoDB->createAggregationBuilder(Products::class)->group()
                        ->field('_id')
                        ->expression(
                            $builder->expr()
                                ->field('size_rus')
                                ->expression('$size_rus')
                                ->field('url')
                                ->expression('$url_code')
                        )
                        ->field('count')
                        ->sum(1)
                        ->group()
                        ->field('_id')
                        ->expression('$_id.size_rus')
                        ->field('count')
                        ->sum(1)
                )
                ->field("shops")
                ->pipeline(
                    $this->mongoDB->createAggregationBuilder(Products::class)->unwind('$shop_count')
                        ->group()
                        ->field('_id')
                        ->expression(
                            $builder->expr()
                                ->field('shop')
                                ->expression('$shop_count.shop')
                                ->field('url')
                                ->expression('$url_code')
                        )
                        ->field('count')
                        ->sum(1)
                        ->group()
                        ->field('_id')
                        ->expression('$_id.shop')
                        ->field('count')
                        ->sum(1)
                )
        ;
        $data = $builder->execute()->toArray();
//        print_r($data);

//        echo "ok";
        return new HtmlResponse($this->template->render('app::test', [
            'data' => print_r($data,true)
        ]));
        // TODO: Implement process() method.
    }
}