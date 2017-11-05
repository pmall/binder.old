<?php

require __DIR__ . '/../Fixtures/definition.php';

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\ServiceProviderFactory;
use Ellipse\Binder\ServiceProviderCollection;

describe('ServiceProviderCollection', function () {

    beforeEach(function () {

        $this->manifest = mock(ManifestFile::class);
        $this->factory = mock(ServiceProviderFactory::class);

        $this->collection = new ServiceProviderCollection(
            $this->manifest->get(),
            $this->factory->get()
        );

    });

    describe('::newInstance()', function () {

        it('should return a new ServiceProviderCollection', function () {

            $test = ServiceProviderCollection::newInstance($this->manifest->get());

            expect($test)->toBeAnInstanceOf(ServiceProviderCollection::class);

        });

    });

    describe('->toArray()', function () {

        it('should proxy the factory ->__invoke() method with all the definition from the manifest file', function () {

            $definition1 = definition('App\\SomeClass');
            $definition2 = definition('App\\SomeOtherClass');

            $provider1 = mock(ServiceProviderInterface::class)->get();
            $provider2 = mock(ServiceProviderInterface::class)->get();

            $this->manifest->definitions->returns([$definition1, $definition2]);

            $this->factory->__invoke->with($definition1)->returns($provider1);
            $this->factory->__invoke->with($definition2)->returns($provider2);

            $test = $this->collection->toArray();

            expect($test)->toEqual([$provider1, $provider2]);

        });

    });

});
