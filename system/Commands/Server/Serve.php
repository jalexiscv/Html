<?php

namespace Higgs\Commands\Server;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;

class Serve extends BaseCommand
{
    protected $group = 'Higgs';
    protected $name = 'serve';
    protected $description = 'Launches the Higgs PHP-Development Server.';
    protected $usage = 'serve';
    protected $arguments = [];
    protected $portOffset = 0;
    protected $tries = 10;
    protected $options = ['--php' => 'The PHP Binary [default: "PHP_BINARY"]', '--host' => 'The HTTP Host [default: "localhost"]', '--port' => 'The HTTP Host Port [default: "8080"]',];

    public function run(array $params)
    {
        $php = escapeshellarg(CLI::getOption('php') ?? PHP_BINARY);
        $host = CLI::getOption('host') ?? 'localhost';
        $port = (int)(CLI::getOption('port') ?? 8080) + $this->portOffset;
        CLI::write('Higgs development server started on http://' . $host . ':' . $port, 'green');
        CLI::write('Press Control-C to stop.');
        $docroot = escapeshellarg(FCPATH);
        $rewrite = escapeshellarg(__DIR__ . '/rewrite.php');
        passthru($php . ' -S ' . $host . ':' . $port . ' -t ' . $docroot . ' ' . $rewrite, $status);
        if ($status && $this->portOffset < $this->tries) {
            $this->portOffset++;
            $this->run($params);
        }
    }
}