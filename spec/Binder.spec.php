<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder;
use Ellipse\Binder\Filesystem;
use Ellipse\Binder\ManifestFile;

describe('Binder', function () {

    beforeEach(function () {

        $this->manifest = mock(ManifestFile::class);

        $this->binder = new Binder($this->manifest->get());

    });

    describe('::newInstance()', function () {

        it('should return a Binder instance', function () {

            $test = Binder::newInstance(getcwd());

            expect($test)->toBeAnInstanceOf(Binder::class);

        });

    });

    describe('->providers()', function () {

        it('should return the service providers defined by the project manifest file', function () {

            $providers = [
                mock(ServiceProviderInterface::class)->get(),
                mock(ServiceProviderInterface::class)->get(),
            ];

            $this->manifest->providers->returns($providers);

            $test = $this->binder->providers();

            expect($test)->toEqual($providers);

        });

    });

});
