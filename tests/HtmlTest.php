<?php
declare(strict_types=1);

namespace Higgs\Html\Tests;

use Higgs\Html\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    public function testTagCreation(): void
    {
        $tag = Html::tag('div', ['class' => 'test'], 'content');
        $this->assertEquals('<div class="test">content</div>', (string)$tag);
    }

    public function testCachedTagCreation(): void
    {
        $tag1 = Html::tag('button', ['class' => 'btn'], 'Click', true);
        $tag2 = Html::tag('button', ['class' => 'btn'], 'Click', true);
        
        $this->assertEquals((string)$tag1, (string)$tag2);
        $this->assertNotSame($tag1, $tag2); // Deben ser diferentes instancias
    }

    public function testFormCreation(): void
    {
        $form = Html::form(['action' => '/submit']);
        $this->assertStringContainsString('novalidate', (string)$form);
    }

    public function testFormFieldCreation(): void
    {
        $field = Html::formField('text', 'username', [
            'required' => true,
            'label' => 'Username'
        ]);
        
        $output = (string)$field;
        $this->assertStringContainsString('aria-required="true"', $output);
        $this->assertStringContainsString('aria-label="Username"', $output);
    }

    public function testThemeSystem(): void
    {
        Html::registerTheme('test-theme', [
            'class' => 'themed',
            'data-theme' => 'dark'
        ]);

        $tag = Html::tag('div');
        Html::applyTheme($tag, 'test-theme');
        
        $output = (string)$tag;
        $this->assertStringContainsString('class="themed"', $output);
        $this->assertStringContainsString('data-theme="dark"', $output);
    }

    public function testWebComponentCreation(): void
    {
        $component = Html::webComponent('custom-element', ['attr' => 'value']);
        $this->assertEquals('<custom-element attr="value"></custom-element>', (string)$component);
    }

    public function testWebComponentValidation(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Html::webComponent('invalid', []); // Debería fallar porque no tiene guión
    }

    public function testCacheClearing(): void
    {
        $tag1 = Html::tag('div', [], 'test', true);
        Html::clearCache();
        $tag2 = Html::tag('div', [], 'test', true);
        
        // Las instancias deben ser diferentes después de limpiar la caché
        $this->assertNotSame(spl_object_hash($tag1), spl_object_hash($tag2));
    }

    public function testContentEscaping(): void
    {
        $tag = Html::tag('div', [], '<script>alert("xss")</script>');
        $this->assertEquals('<div>&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;</div>', (string)$tag);
    }
}
