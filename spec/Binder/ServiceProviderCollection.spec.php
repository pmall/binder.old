<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\ServiceProviderCollection;
use Ellipse\Binder\Definitions\DefinitionInterface;

describe('ServiceProviderCollection', function () {

    beforeEach(function () {

        $this->manifest = mock(ManifestFile::class);

        $this->collection = new ServiceProviderCollection($this->manifest->get());

    });

    describe('->toArray()', function () {

        it('should return all the definitions from the manifest file as service providers', function () {

            $definition1 = mock(DefinitionInterface::class);
            $definition2 = mock(DefinitionInterface::class);
            $provider1 = mock(ServiceProviderInterface::class)->get();
            $provider2 = mock(ServiceProviderInterface::class)->get();

            $definition1->toServiceProvider->returns($provider1);
            $definition2->toServiceProvider->returns($provider2);

            $this->manifest->definitions->returns([$definition1->get(), $definition2->get()]);

            $test = $this->collection->toArray();

            expect($test)->toEqual([$provider1, $provider2]);

        });

    });

});
