# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.3.2] - 2025-12-14

### Chore
- **Repository Cleanup**: Removed tracked `composer.phar` binary from the repository.

## [2.3.1] - 2025-12-14

### Fixed
- **Dynamic Properties**: Resolved "Creation of dynamic property is deprecated" warning in `AbstractTag` and `AbstractAttributes`.

## [2.3.0] - 2025-12-14

### Documentation
- **PHPDocs**: Comprehensive update to `HtmlElementsTrait`, `Html`, `AbstractTag`, and `HtmlTag`. All methods now include detailed `@param` and `@return` descriptions with types.

### Optimization & Modernization
- **Factories**: `AttributeFactory` and `AttributesFactory` now bypass `ReflectionClass` for standard objects, improving instantiation speed.
- **Attributes**: Updated `AbstractAttribute` and `AbstractAttributes` to use **Constructor Property Promotion** and modern `__serialize`/`__unserialize`.
- **Stringable**: `StringableInterface` now extends the native PHP `\Stringable`.

### Strict Typing (Standards)
- **Interfaces**: Added strict PHP 8.2 return types (`: bool`, `: int`, `: void`, etc.) to `AttributeInterface` and `AttributesInterface` for `ArrayAccess` and `Iterator` methods, replacing temporary `#[ReturnTypeWillChange]` attributes.

### Security (Critical)
- **XSS Protection**: Enabled `htmlspecialchars` in `AbstractTag::escape()` to prevent Cross-Site Scripting.

### Changed
- **Modernization**: `AbstractTag` now uses Constructor Property Promotion and `readonly` properties (PHP 8.1+).
- **Serialization**: Replaced deprecated `Serializable` interface with `__serialize` and `__unserialize` magic methods.
- **Optimization**: `TagFactory` now instantiates standard `Tag` objects directly, bypassing reflection for better performance.

## [2.2.0] - 2025-12-14

### Changed
- **PHP Requirement**: Bumped minimum PHP version to `^8.2`.
- **Quality Assurance**: Added PHPStan (Level 5) and PHP_CodeSniffer (PSR-12) configurations.

### Removed
- **LegacyHtmlTrait**: Completely removed the deprecated legacy trait. Methods like `Html::get_Div` are no longer available.

## [2.1.0] - 2025-12-14

### Added
- **HtmlElementsTrait**: Extracted semantic HTML helpers to a dedicated trait for better code organization.
- **Modern PHP 8 Features**: Refactored `AbstractBaseHtmlTagObject` to use `match` expressions and strict typing.

### Deprecated
- **Legacy Methods**: Methods like `Html::get_Div`, `Html::get_Img`, etc. are now deprecated. Use `Html::div`, `Html::img` instead.

## [2.0.0] - 2025-12-14

### Changed
- **Architecture Pivot**: The library has been refactored to be a pure, agnostic HTML generator.
- **Namespace**: Core functionality remains under `Higgs\Html`, but framework-specific logic has been removed.

### Removed
- **Bootstrap 5 Dependencies**: All components in `Higgs\Html\Components` (Card, Modal, Button, Score, etc.) have been removed to ensure the library remains pure.
- **Legacy Components**: Removed `ProgressBar` and other UI-specific implementations.
- **Documentation**: Removed Bootstrap-specific documentation files.

### Added
- **Pure HTML Focus**: Validated core `Html`, `Tag`, and `Attribute` classes for generic HTML generation.
- **Strict Void Elements**: Implemented logic to automatically handle void elements (e.g., `<img>`, `<br>`, `<input>`) by rendering them without closing tags, while ensuring non-void elements always have closing tags.
- **Semantic Helpers**: Added static helper methods to `Html` class for common tags: `div`, `span`, `p`, `a`, `img`, `ul`, `ol`, `li`, `input`, `button`, `script`, `link`, `meta`.
- **Magic Attribute Setters**: Added support for setting attributes via method calls (e.g., `$tag->id('my-id')`).
