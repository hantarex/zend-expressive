<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 06.12.2017
 * Time: 16:41
 */

namespace Auth\Action;


use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;

class FooAction
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $user = $request->getAttribute(AuthAction::class);
        // $user will contains the user's identity
    }
}