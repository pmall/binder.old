<?php declare(strict_types=1);

namespace Ellipse\Binder\Exceptions;

use RuntimeException;

class ServiceProviderClassNotFoundException extends RuntimeException implements BinderExceptionInterface
{
    public function __construct(string $value)
    {
        $msg = 'Service provider class \'%s\' not found.';

        parent::__construct(sprintf($msg, $value));
    }
}
