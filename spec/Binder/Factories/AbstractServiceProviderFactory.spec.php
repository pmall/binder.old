<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\partialMock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ServiceProviderFactoryInterface;
use Ellipse\Binder\Factories\AbstractServiceProviderFactory;

describe('AbstractServiceProviderFactory', function () {

    beforeEach(function () {

        $this->factory = partialMock(AbstractServiceProviderFactory::class);

    });

    it('should implement ServiceProviderFactoryInterface', function () {

        expect($this->factory->get())->toBeAnInstanceOf(ServiceProviderFactoryInterface::class);

    });

    describe('->__invoke()', function () {

        context('when the ->canHandle() method returns true', function () {

            it('should proxy the ->createServiceProvider() method', function () {

                $definition = ['type' => 'class', 'value' => 'App\\SomeClass'];

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->factory->canHandle->returns(true);
                $this->factory->createServiceProvider->returns($provider);

                $test = ($this->factory->get())($definition);
                expect($test)->toBe($provider);
                $this->factory->canHandle->calledWith('class');
                $this->factory->createServiceProvider->calledWith('App\\SomeClass');

            });

        });

        context('when the ->canHandle() method returns false', function () {

            it('should proxy the ->delegate() method', function () {

                $definition = ['type' => 'class', 'value' => 'App\\SomeClass'];

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->factory->canHandle->returns(false);
                $this->factory->delegate->returns($provider);

                $test = ($this->factory->get())($definition);
                expect($test)->toBe($provider);
                $this->factory->canHandle->calledWith('class');
                $this->factory->delegate->calledWith($definition);

            });

        });

    });

});
