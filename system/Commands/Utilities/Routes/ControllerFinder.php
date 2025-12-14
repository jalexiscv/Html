<?php

namespace Higgs\Commands\Utilities\Routes;

use Higgs\Autoloader\FileLocator;
use Higgs\Config\Services;

final class ControllerFinder
{
    private string $namespace;
    private FileLocator $locator;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
        $this->locator = Services::locator();
    }

    public function find(): array
    {
        $nsArray = explode('\\', trim($this->namespace, '\\'));
        $count = count($nsArray);
        $ns = '';
        for ($i = 0; $i < $count; $i++) {
            $ns .= '\\' . array_shift($nsArray);
            $path = implode('\\', $nsArray);
            $files = $this->locator->listNamespaceFiles($ns, $path);
            if ($files !== []) {
                break;
            }
        }
        $classes = [];
        foreach ($files as $file) {
            if (\is_file($file)) {
                $classnameOrEmpty = $this->locator->getClassname($file);
                if ($classnameOrEmpty !== '') {
                    $classname = $classnameOrEmpty;
                    $classes[] = $classname;
                }
            }
        }
        return $classes;
    }
}