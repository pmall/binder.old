<?php

use Ellipse\Binder\Factories\ClassServiceProviderFactory;

if (! function_exists('definition')) {

    function definition(string $class)
    {
        return [
            'type' => ClassServiceProviderFactory::TYPE_CLASS,
            'value' => $class,
        ];
    }

}

if (! function_exists('definitions')) {

    function definitions(array $classes)
    {
        return array_map('definition', $classes);
    }

}
