<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 01.12.2017
 * Time: 13:03
 */

namespace Auth;


use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class MyAuthAdapter implements AdapterInterface
{

    private $password;
    private $username;

    public function __construct(/* any dependencies */)
    {
        // Likely assign dependencies to properties
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $row=[
            'password'=>'1',
            'user'=>'1'
        ];
        // TODO: Implement authenticate() method.
//        if (password_verify($this->password, $row['password'])) {
        if ($this->password == $row['password']) {
            return new Result(Result::SUCCESS, $row);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }
}