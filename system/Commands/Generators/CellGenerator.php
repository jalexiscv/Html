<?php

namespace Higgs\Commands\Generators;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\GeneratorTrait;

class CellGenerator extends BaseCommand
{
    use GeneratorTrait;

    protected $group = 'Generators';
    protected $name = 'make:cell';
    protected $description = 'Generates a new Cell file and its view.';
    protected $usage = 'make:cell <name> [options]';
    protected $arguments = ['name' => 'The cell class name.',];
    protected $options = ['--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".', '--suffix' => 'Append the component title to the class name (e.g. User => UserCell).', '--force' => 'Force overwrite existing file.',];

    public function run(array $params)
    {
        $this->component = 'Cell';
        $this->directory = 'Cells';
        $this->template = 'cell.tpl.php';
        $this->classNameLang = 'CLI.generator.className.cell';
        $this->generateClass($params);
        $this->classNameLang = 'CLI.generator.viewName.cell';
        $segments = explode('\\', $this->qualifyClassName());
        $view = array_pop($segments);
        $view = str_replace('Cell', '', decamelize($view));
        if (strpos($view, '_cell') === false) {
            $view .= '_cell';
        }
        $segments[] = $view;
        $view = implode('\\', $segments);
        $this->template = 'cell_view.tpl.php';
        $this->generateView($view, $params);
    }
}