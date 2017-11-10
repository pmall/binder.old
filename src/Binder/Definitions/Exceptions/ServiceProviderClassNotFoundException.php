<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions\Exceptions;

use UnexpectedValueException;

class ServiceProviderClassNotFoundException extends UnexpectedValueException implements DefinitionExceptionInterface
{
    public function __construct(string $value)
    {
        $msg = "Service provider class '%s' not found.";

        parent::__construct(sprintf($msg, $value));
    }
}
