<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\DefinitionTypeNotValidException;

describe('DefinitionTypeNotValidException', function () {

    beforeEach(function () {

        $this->exception = new DefinitionTypeNotValidException('type');

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
