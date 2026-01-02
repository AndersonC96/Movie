<?php

declare(strict_types=1);

/**
 * PSR-4 Autoloader
 * 
 * Automatically loads classes based on namespace.
 * 
 * @package Core
 */

spl_autoload_register(function (string $class): void {
    // Project-specific namespace prefix
    $prefixes = [
        'Core\\'    => __DIR__ . '/src/Core/',
        'App\\'     => __DIR__ . '/src/App/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        // Does the class use the namespace prefix?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Get the relative class name
        $relativeClass = substr($class, $len);

        // Replace namespace separators with directory separators
        // and append .php
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // If the file exists, require it
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
