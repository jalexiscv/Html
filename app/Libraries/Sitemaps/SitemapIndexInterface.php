<?php

namespace App\Libraries\Sitemaps;

/**
 * @package Melbahja\Seo
 * @since v1.0
 * @see https://git.io/phpseo
 * @license MIT
 * @copyright 2021 Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 */
interface SitemapIndexInterface extends SitemapInterface
{
    public function __construct(string $domain, array $options = null);

    public function setOptions(array $options): SitemapIndexInterface;

    public function getOptions(): array;

    public function saveTo(string $path): bool;

    public function save(): bool;

    public function build(SitemapBuilderInterface $builder, array $options, callable $func): SitemapIndexInterface;

    public function __call(string $builder, array $args): SitemapIndexInterface;
}
