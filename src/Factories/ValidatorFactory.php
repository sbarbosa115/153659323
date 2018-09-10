<?php

namespace App\Factories;

use Illuminate\Validation\Factory;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class ValidatorFactory
{
    protected $factory;

    public function __construct()
    {
        $translator = $this->setupTranslator();
        $this->factory = new Factory($translator);
    }

    protected function setupTranslator()
    {
        $translator = new Translator('en', new MessageSelector);
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [
            'validation' => [
                'required' 				=> 'The :attribute field is required.',
                'min' 					=> [
                    'numeric' 			=> 'The :attribute must be at least :min.',
                ],
                'string' 				=> 'The :attribute must be a string.',
                'numeric' 				=> 'The :attribute must be a number.',
                'in' 					=> 'The selected :attribute is invalid.',
                'size' 					=> [
                    'numeric' 			=> 'The :attribute must be :size.',
                ],
            ]
        ], 'en');

        return $translator;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->factory, $method], $args);
    }
}
