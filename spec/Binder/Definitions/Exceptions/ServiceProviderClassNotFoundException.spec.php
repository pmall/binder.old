<?php

use Ellipse\Binder\Definitions\Exceptions\DefinitionExceptionInterface;
use Ellipse\Binder\Definitions\Exceptions\ServiceProviderClassNotFoundException;

describe('ServiceProviderClassNotFoundException', function () {

    beforeEach(function () {

        $this->exception = new ServiceProviderClassNotFoundException('App\\SomeProvider');

    });

    it('should implement DefinitionExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(DefinitionExceptionInterface::class);

    });

});
