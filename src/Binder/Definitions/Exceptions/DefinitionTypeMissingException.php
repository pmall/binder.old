<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions\Exceptions;

use UnexpectedValueException;

class DefinitionTypeMissingException extends UnexpectedValueException implements DefinitionExceptionInterface
{
    public function __construct(array $data)
    {
        $msg = "The definition does not have a 'type' key.\n%s";

        parent::__construct(sprintf($msg, print_r($data, true)));
    }
}
