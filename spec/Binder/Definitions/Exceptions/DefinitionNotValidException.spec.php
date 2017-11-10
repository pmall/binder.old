<?php

use Ellipse\Binder\Definitions\Exceptions\DefinitionExceptionInterface;
use Ellipse\Binder\Definitions\Exceptions\DefinitionNotValidException;

describe('DefinitionNotValidException', function () {

    beforeEach(function () {

        $this->exception = new DefinitionNotValidException(['type', 'key'], ['type' => 'value']);

    });

    it('should implement DefinitionExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(DefinitionExceptionInterface::class);

    });

});
