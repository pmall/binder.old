<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\ServiceProviderClassNotFoundException;

describe('ServiceProviderClassNotFoundException', function () {

    beforeEach(function () {

        $this->exception = new ServiceProviderClassNotFoundException('App\\SomeProvider');

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
