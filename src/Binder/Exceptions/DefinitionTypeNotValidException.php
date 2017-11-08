<?php declare(strict_types=1);

namespace Ellipse\Binder\Exceptions;

use UnexpectedValueException;

class DefinitionTypeNotValidException extends UnexpectedValueException implements BinderExceptionInterface
{
    public function __construct(string $type)
    {
        $msg = "The value '%s' is not a valid service provider definition type.";

        parent::__construct(sprintf($msg, $type));
    }
}
