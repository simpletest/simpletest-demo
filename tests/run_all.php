<?php
// Load Composer autoload (App\ and tests autoloading)
require_once __DIR__ . '/../vendor/autoload.php';

// Include SimpleTest autorun once so it registers the autorunner with the
// correct initial file (this script) and initial classes context.
require_once __DIR__ . '/../vendor/simpletest/simpletest/src/autorun.php';

// Include every PHP file in this directory except this runner.
foreach (glob(__DIR__ . '/*.php') as $file) {
    if (realpath($file) === realpath(__FILE__)) {
        continue;
    }

    $contents = file_get_contents($file);

    // Try to detect a single class declared in the file (with optional namespace).
    $namespace = '';
    if (preg_match('/^\s*namespace\s+([^;\s]+)\s*;/m', $contents, $m)) {
        $namespace = trim($m[1]);
    }

    $class = null;
    if (preg_match('/^\s*(?:abstract\s+|final\s+)?class\s+([A-Za-z0-9_]+)/m', $contents, $m)) {
        $class = $m[1];
    }

    if ($class) {
        $fqcn = $namespace ? ($namespace . '\\' . $class) : $class;
        // If class already exists (for example Composer's optimized autoload preloaded it), skip requiring.
        if (class_exists($fqcn, false) || interface_exists($fqcn, false) || trait_exists($fqcn, false)) {
            continue;
        }
    }

    require_once $file;
}
