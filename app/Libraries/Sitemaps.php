<?php

namespace App\Libraries;

use App\Libraries\Sitemaps\SitemapIndex;
use App\Libraries\Sitemaps\SitemapException;
use App\Libraries\Sitemaps\SitemapIndexInterface;
use App\Libraries\Sitemaps\SitemapBuilderInterface;
use App\Libraries\Sitemaps\LinksBuilder;

/**
 * @package Higgs\Libraries\Seo
 * @since v1.0
 * @see https://Higgs.com
 * @license MIT
 * @copyright 2021 Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 */
class Sitemaps implements SitemapIndexInterface
{

    /**
     * Sitemap options
     * @var array
     */
    protected $options = [
        'save_path' => null,
        'index_name' => 'sitemap.xml',
        'sitemaps_url' => null
    ]

        /**
         * Sitemap files
         * @var array
         */
    , $sitemaps = []

        /**
         * Sitemaps domain name
         * @var string
         */
    , $domain;

    /**
     * Initialize new sitemap builder
     *
     * @param string $domain The domain name only
     * @param array $options
     */
    public function __construct(string $domain, array $options = null)
    {
        $this->domain = $domain;

        if ($options !== null) {

            $this->setOptions($options);
        }
    }

    /**
     * Get all sitemap options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set builer options
     *
     * @param array $options
     * @return SitemapIndexInterface
     */
    public function setOptions(array $options): SitemapIndexInterface
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Set save path
     * @param string $path
     * @return SitemapIndexInterface
     */
    public function setSavePath(string $path): SitemapIndexInterface
    {
        $this->options['save_path'] = $path;
        return $this;
    }

    /**
     * Get save path
     * @return null|string
     */
    public function getSavePath(): ?string
    {
        return $this->options['save_path'];
    }

    /**
     * Set index name
     *
     * @param string $name
     * @return SitemapIndexInterface
     */
    public function setIndexName(string $name): SitemapIndexInterface
    {
        $this->options['index_name'] = $name;
        return $this;
    }

    /**
     * Get Index name
     * @return string
     */
    public function getIndexName(): string
    {
        return $this->options['index_name'];
    }

    /**
     * Set sitemaps url
     * @param string $url
     * @return SitemapIndexInterface
     */
    public function setSitemapsUrl(string $url): SitemapIndexInterface
    {
        $this->options['sitemaps_url'] = $url;
        return $this;
    }

    /**
     * Get sitemaps url
     * @return null|string
     */
    public function getSitemapsUrl(): ?string
    {
        return $this->options['sitemaps_url'];
    }

    /**
     * Get sitemaps domain
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * {@method saveTo} by pre defined save_path option
     *
     * @param string $path
     * @return bool
     */
    public function save(): bool
    {
        if (is_string($this->options['save_path']) === false) {

            throw new SitemapException('Invalid or missing save_path option');
        }

        return $this->saveTo($this->options['save_path']);
    }

    /**
     * Set sitemaps to a path
     * @param string $path
     * @return bool
     */
    public function saveTo(string $path): bool
    {
        return SitemapIndex::build(
            $this->options['index_name'],
            $path,
            ($this->options['sitemaps_url'] ?? $this->domain), $this->sitemaps
        );
    }

    /**
     * Generate sitemaps
     *
     * @param SitemapBuilderInterface $builder
     * @param array $options
     * @param callable $func
     * @return SitemapIndexInterface
     */
    public function build(SitemapBuilderInterface $builder, array $options, callable $func): SitemapIndexInterface
    {
        if (isset($this->sitemaps[$options['name']])) {

            throw new SitemapException("The sitemap {$name} already registred!");
        }

        # Call generator
        call_user_func_array($func, [$builder]);

        return $this->setBuilder($options['name'], $builder);
    }

    /**
     * Build registred sitemap and save it on temp
     * @param string $name
     * @param SitemapBuilderInterface $builder
     * @return SitemapIndexInterface
     */
    protected function setBuilder(string $name, SitemapBuilderInterface $builder): SitemapIndexInterface
    {
        $this->sitemaps[$name] = $builder->saveTemp();

        return $this;
    }

    /**
     * Sitemaps generator
     *
     * @param string $builder
     * @param array $args
     * @return SitemapIndexInterface
     */
    public function __call(string $builder, array $args): SitemapIndexInterface
    {
        if (class_exists($builder = 'App\Libraries\Sitemaps\\' . ucfirst($builder) . 'Builder')) {
            if (count($args) !== 2) {
                throw new SitemapException("Invalid {$builder} arguments");
            } elseif (is_string($args[0])) {
                $args[0] = ['name' => $args[0]];
            }
            if (isset($args[0]['name']) === false) {
                throw new SitemapException("Sitemap name is required for {$builder}");
            }
            return $this->build(new $builder($this->domain, $args[0]), ...$args);
        }
        throw new SitemapException("Sitemap builder {$builder} not exists");
    }

}
