<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 04.12.2017
 * Time: 12:24
 */

namespace Auth;


use Interop\Container\ContainerInterface;

class MyAuthAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Retrieve any dependencies from the container when creating the instance
        return new MyAuthAdapter(/* any dependencies */);
    }
}