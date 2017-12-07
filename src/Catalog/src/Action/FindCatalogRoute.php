<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 07.12.2017
 * Time: 13:47
 */

namespace Catalog\Action;


use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FindCatalogRoute implements MiddlewareInterface
{

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
        
        // TODO: Implement process() method.
        return $delegate->process($request);
    }
}