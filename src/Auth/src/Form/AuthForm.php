<?php

/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 04.12.2017
 * Time: 16:14
 */

namespace Auth\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Captcha;
use Zend\Form\Element\Hidden;
use Zend\Captcha\Image;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AuthForm extends Form
{
    const LOGIN = 'username';
    const REDIRECT_URL = 'redirect_url';
    const CAPTCHA = 'captcha';
    const PASSWORD = 'password';

    /**
     * AuthForm constructor.
     */
    public function __construct()
    {
        parent::__construct('auth-from');

        $this->addElements();

        $this->addInputFilter();
    }

    private function addElements()
    {
        Image::$VN=["1", "2", "3", "4", "5", "6", "7", "8", "9"];
        Image::$CN=Image::$VN;
        $this->add([
            'type' => Text::class,
            'name' => self::LOGIN,
            'options' => [
                'label' => 'Логин'
            ],
            'attributes' => [
                'required' => true,
                'placeholder' => 'Логин',
                'autofocus' => true
//                'value' =>
            ]
        ]);

        $this->add([
            'type' => Password::class,
            'name' => self::PASSWORD,
            'options' => [
                'label' => 'Пароль'
            ],
            'attributes' => [
                'required' => true,
                'placeholder' => 'Пароль',
//                'value' =>
            ]
        ]);

        $this->add([
            'type' => Hidden::class,
            'name' => self::REDIRECT_URL
        ]);

        $this->add([
            'type'=>Captcha::class,
            'name'=>'captcha',
            'options'=>[
                'label'=>'Введите буквы с картинки',
                'captcha'=>[
                    'class'=>Image::class,
                    'font'   => __DIR__.'/Data/arial.ttf',
                    'imgDir' => 'public/img/captcha',
                    'imgUrl' => '/img/captcha/',
                    'wordLen'=>4,
                    'useNumbers'=>true
                ]
            ]
        ]);

        $this->add([
            'type'=>Button::class,
            'name'=>'submit',
            'attributes' => [
                'id' => 'submit',
                'type'=>'submit'
            ],
            'options'=>[
                'label'=>'Войти'
            ]
        ]);
    }

    private function addInputFilter()
    {
        $inputFilter=new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'=>self::LOGIN,
            'required'=>true,
            'filters'=>[
                ['name'=>'StringTrim']
            ]
        ]);

        $inputFilter->add([
            'name'=> self::PASSWORD,
            'required'=>true,
            'filters'=>[

            ],
            'validators'=>[
            ]
        ]);

        $inputFilter->add([
            'name'     => 'redirect_url',
            'required' => false,
            'filters'  => [
                ['name'=>'StringTrim']
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 2048
                    ]
                ],
            ],
        ]);
    }
}