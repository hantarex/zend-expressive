<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 31.01.2018
 * Time: 13:39
 */

namespace Mongo\Service;


use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;

class MongoDBService
{
    const MONGO_COLLECTION_PRODUCTS = "products";

    /**
     * MongoDBService constructor.
     * @param MongoDBDriver $db
     */
    public function __construct(Database $db)
    {
        $this->db=$db;
    }

    public function test(){
        $result = $this->db->selectCollection(self::MONGO_COLLECTION_PRODUCTS)->aggregate(
            [
        [
            '$match'=> [
            '$and'=> [
                    [ "category"=> 22690 ],
                    [
                        '$or' => [

                            ["brand"=> "NIKE"]
                        ]
                    ]
                ]

            ]
        ],
        [ '$facet'=>
            [
                "brands"=>
                    [
                        [
                            '$group'=>
                                [
                                    '_id'=> [
                                    'brand'=>'$brand',
                                       'url'=>'$url_code'
                                    ],
                                    'count'=> [ '$sum'=> 1 ],
                                ]
                         ],

                         [
                             '$group'=>
                             [
                                 '_id'=> '$_id.brand',
                                 'count'=> ['$sum'=>1]
                             ]
                         ] ,
                          [ '$sort'=>['count'=>-1]]
                     ],
                 "profs"=>
                     [
                         [
                             '$group'=>
                                [
                                    '_id'=> [
                                    'prof'=>'$prof',
                                       'url'=>'$url_code'
                                    ],
                                    'count'=> [ '$sum'=> 1 ],
                                ]
                         ],

                         [
                             '$group'=>
                             [
                                 '_id'=> '$_id.prof',
                                 'count'=> ['$sum'=>1]
                             ]
                         ],
                         ['$sort'=>['count'=>-1]]
                     ],
                 "size_rus"=>
                     [
                         [
                             '$group'=>
                                [
                                    '_id'=> [
                                    'size_rus'=>'$size_rus',
                                       'url'=>'$url_code'
                                    ],
                                    'count'=> [ '$sum'=> 1 ],
                                ]
                         ],

                         [
                             '$group'=>
                             [
                                 '_id'=> '$_id.size_rus',
                                 'count'=> ['$sum'=>1]
                             ]
                         ],
                        ['$sort'=>['count'=>-1]]
                     ],
                 "shops"=>
                     [
                         [
                             '$unwind'=>
                                [
                                    'path'=> '$shop_count'
                                ]
                          ],
                          [
                              '$group'=>
                                [
                                    '_id'=> [
                                    'shop'=>'$shop_count.shop',
                                       'url'=>'$url_code'
                                    ],
                                    'count'=> [ '$sum'=> 1 ],
                                ]
                         ],
                         [
                             '$group'=>
                             [
                                 '_id'=> '$_id.shop',
                                 'count'=> ['$sum'=>1]
                             ]
                         ],
                        ['$sort'=>['count'=>-1]]
                      ]
                 ]
            ]
        ]
        );
        $i=0;
        /** @var BSONDocument $item */
        foreach ($result as $item){
            /** @var BSONArray $brands */
            $brands=$item->offsetGet('brands');
            /** @var BSONDocument $brand */
            $brand=$brands->bsonSerialize()[0];
            var_dump($brand->jsonSerialize());
            $i++;
            if($i>10) break;
        }
    }
}