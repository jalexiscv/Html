<?php

namespace Higgs\Commands\Generators;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Higgs\CLI\GeneratorTrait;
use Higgs\Controller;
use Higgs\RESTful\ResourceController;
use Higgs\RESTful\ResourcePresenter;

class ControllerGenerator extends BaseCommand
{
    use GeneratorTrait;

    protected $group = 'Generators';
    protected $name = 'make:controller';
    protected $description = 'Generates a new controller file.';
    protected $usage = 'make:controller <name> [options]';
    protected $arguments = ['name' => 'The controller class name.',];
    protected $options = ['--bare' => 'Extends from Higgs\Controller instead of BaseController.', '--restful' => 'Extends from a RESTful resource, Options: [controller, presenter]. Default: "controller".', '--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".', '--suffix' => 'Append the component title to the class name (e.g. User => UserController).', '--force' => 'Force overwrite existing file.',];

    public function run(array $params)
    {
        $this->component = 'Controller';
        $this->directory = 'Controllers';
        $this->template = 'controller.tpl.php';
        $this->classNameLang = 'CLI.generator.className.controller';
        $this->execute($params);
    }

    protected function prepare(string $class): string
    {
        $bare = $this->getOption('bare');
        $rest = $this->getOption('restful');
        $useStatement = trim(APP_NAMESPACE, '\\') . '\Controllers\BaseController';
        $extends = 'BaseController';
        if ($bare || $rest) {
            if ($bare) {
                $useStatement = Controller::class;
                $extends = 'Controller';
            } elseif ($rest) {
                $rest = is_string($rest) ? $rest : 'controller';
                if (!in_array($rest, ['controller', 'presenter'], true)) {
                    $rest = CLI::prompt(lang('CLI.generator.parentClass'), ['controller', 'presenter'], 'required');
                    CLI::newLine();
                }
                if ($rest === 'controller') {
                    $useStatement = ResourceController::class;
                    $extends = 'ResourceController';
                } elseif ($rest === 'presenter') {
                    $useStatement = ResourcePresenter::class;
                    $extends = 'ResourcePresenter';
                }
            }
        }
        return $this->parseTemplate($class, ['{useStatement}', '{extends}'], [$useStatement, $extends], ['type' => $rest]);
    }
}