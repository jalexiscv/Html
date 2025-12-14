<?php

namespace Higgs\Config;

use Higgs\View\ViewDecoratorInterface;

class View extends BaseConfig
{
    public $saveData = true;
    public $filters = [];
    public $plugins = [];
    public array $decorators = [];
    protected $coreFilters = ['abs' => '\abs', 'capitalize' => '\Higgs\View\Filters::capitalize', 'date' => '\Higgs\View\Filters::date', 'date_modify' => '\Higgs\View\Filters::date_modify', 'default' => '\Higgs\View\Filters::default', 'esc' => '\Higgs\View\Filters::esc', 'excerpt' => '\Higgs\View\Filters::excerpt', 'highlight' => '\Higgs\View\Filters::highlight', 'highlight_code' => '\Higgs\View\Filters::highlight_code', 'limit_words' => '\Higgs\View\Filters::limit_words', 'limit_chars' => '\Higgs\View\Filters::limit_chars', 'local_currency' => '\Higgs\View\Filters::local_currency', 'local_number' => '\Higgs\View\Filters::local_number', 'lower' => '\strtolower', 'nl2br' => '\Higgs\View\Filters::nl2br', 'number_format' => '\number_format', 'prose' => '\Higgs\View\Filters::prose', 'round' => '\Higgs\View\Filters::round', 'strip_tags' => '\strip_tags', 'title' => '\Higgs\View\Filters::title', 'upper' => '\strtoupper',];
    protected $corePlugins = ['csp_script_nonce' => '\Higgs\View\Plugins::cspScriptNonce', 'csp_style_nonce' => '\Higgs\View\Plugins::cspStyleNonce', 'current_url' => '\Higgs\View\Plugins::currentURL', 'previous_url' => '\Higgs\View\Plugins::previousURL', 'mailto' => '\Higgs\View\Plugins::mailto', 'safe_mailto' => '\Higgs\View\Plugins::safeMailto', 'lang' => '\Higgs\View\Plugins::lang', 'validation_errors' => '\Higgs\View\Plugins::validationErrors', 'route' => '\Higgs\View\Plugins::route', 'siteURL' => '\Higgs\View\Plugins::siteURL',];

    public function __construct()
    {
        $this->filters = array_merge($this->coreFilters, $this->filters);
        $this->plugins = array_merge($this->corePlugins, $this->plugins);
        parent::__construct();
    }
}