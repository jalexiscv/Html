<?php

declare(strict_types=1);

/**
 * This file is part of Higgs 4 framework.
 *
 * (c) Higgs Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Higgs\Validation\Exceptions;

use Higgs\Exceptions\FrameworkException;

class ValidationException extends FrameworkException
{
    /**
     * Throws when the validation rule is not found.
     *
     * @return static
     */
    public static function forRuleNotFound(?string $rule = null)
    {
        return new static(lang('Validation.ruleNotFound', [$rule]));
    }

    /**
     * Throws when the group value of config is not set.
     *
     * @return static
     */
    public static function forGroupNotFound(?string $group = null)
    {
        return new static(lang('Validation.groupNotFound', [$group]));
    }

    /**
     * Throws when the group value of config is not array type.
     *
     * @return static
     */
    public static function forGroupNotArray(?string $group = null)
    {
        return new static(lang('Validation.groupNotArray', [$group]));
    }

    /**
     * Throws when the template of config is invalid.
     *
     * @return static
     */
    public static function forInvalidTemplate(?string $template = null)
    {
        return new static(lang('Validation.invalidTemplate', [$template]));
    }

    /**
     * Throws when there is no any rule set.
     *
     * @return static
     */
    public static function forNoRuleSets()
    {
        return new static(lang('Validation.noRuleSets'));
    }
}
