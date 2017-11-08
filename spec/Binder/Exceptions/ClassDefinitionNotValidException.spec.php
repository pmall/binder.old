<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\ClassDefinitionNotValidException;

describe('ClassDefinitionNotValidException', function () {

    beforeEach(function () {

        $this->exception = new ClassDefinitionNotValidException([]);

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
