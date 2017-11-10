<?php

use Ellipse\Binder\Definitions\Exceptions\DefinitionExceptionInterface;
use Ellipse\Binder\Definitions\Exceptions\DefinitionTypeMissingException;

describe('DefinitionTypeMissingException', function () {

    beforeEach(function () {

        $this->exception = new DefinitionTypeMissingException(['key' => 'value']);

    });

    it('should implement DefinitionExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(DefinitionExceptionInterface::class);

    });

});
