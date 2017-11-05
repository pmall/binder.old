<?php

use Ellipse\Binder\Factories\AbstractServiceProviderFactory;
use Ellipse\Binder\Factories\VoidServiceProviderFactory;
use Ellipse\Binder\Exceptions\ServiceProviderTypeNotValidException;

describe('VoidServiceProviderFactory', function () {

    beforeEach(function () {

        $this->factory = new VoidServiceProviderFactory;

    });

    describe('->__invoke()', function () {

        it('should throw a ServiceProviderTypeNotValidException', function () {

            $test = function () {

                ($this->factory)(['type' => 'something', 'class' => 'App\\SomeClass']);

            };

            $exception = new ServiceProviderTypeNotValidException('something');

            expect($test)->toThrow($exception);

        });

    });

});
