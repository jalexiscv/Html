# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
