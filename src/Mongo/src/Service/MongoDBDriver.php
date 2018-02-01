<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 31.01.2018
 * Time: 13:46
 */

namespace Mongo\Service;


use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;

class MongoDBDriver
{

    /**
     * MongoDBDriver constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config=$config;
        $this->mongo = new Client('mongodb://'.$this->config['connection']['server'].':'.$this->config['connection']['port']);
    }


    /**
     * @return Database
     */
    public function getDatabase(){
        return $this->mongo->selectDatabase($this->config['connection']['database']);
    }
}