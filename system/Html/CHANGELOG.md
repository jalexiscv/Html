# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.7.3] - 2025-12-17

### Documentation
- **README**: Added explanatory video to the introduction.

## [2.7.2] - 2025-12-16

### Documentation
- **Fluent Interface**: Extended `docs/semantica.md` with a dedicated section explaining method chaining and attribute manipulation (`->attr()`, `->class()`, `->id()`).

## [2.7.1] - 2025-12-16

### Documentation
- **Semantic Reference**: Added `docs/semantica.md`, a complete guide listing all available HTML helper methods with examples.
- **README**: Updated main documentation links to include the new semantic reference.

## [2.7.0] - 2025-12-16

### Features
- **100% HTML5 Support**: Implemented over 40 missing HTML5 tags including `picture`, `audio`, `video`, `dialog`, `details`, `time`, `ruby`, `template`, `slot` and more.
- **Atomic Table Builder**: Added `caption()`, `colgroup()`, `col()`, `thead()`, `tbody()`, `tfoot()`, `tr()`, `th()`, `td()` to `HtmlTableTrait` for granular table construction.
- **Advanced Forms**: Added `datalist()`, `output()`, `optgroup()`, `option()` to `HtmlFormTrait`.
- **System Tags**: Added `noscript()`, `address()`, `hgroup()`, `menu()`.
- **Tree Construction**: Added `addChild()` method to `TagInterface` and `AbstractTag` to allow fluent nesting of elements (e.g. `$table->addChild($tbody)`).

### Changed
- **Conflict Resolution**: `Html::time()` now generates the `<time>` semantic tag. The previous form helper for input type time is now aliased as `Html::inputTime()` (or via `Html::input('time')`).

## [2.6.1] - 2025-12-14

### Documentation
- **Architecture**: Published comprehensive `ARCHITECTURE.md` defining development standards and library structure.

### Fixed
- **Bootstrap Facade**: Resolved verification failures in `Navbar` component and `AttributeFactory` related to attribute handling.

## [2.6.0] - 2025-12-14

### Features
- **Smart Legacy Classes**: Added dictionary syntax support for the `class` attribute (`['active' => true]`), improving DX.
- **Multimedia Support**: Added `HtmlMediaTrait` with helpers for `audio()`, `video()`, `source()`, and `track()`.

## [2.5.0] - 2025-12-14

### Features
- **Macroable System**: Added `Html::macro()` to allow dynamic extension of the library.
- **Advanced Form Helpers**: Introduced `HtmlFormTrait` with specific helpers like `select()`, `checkbox()`, `radio()`, `email()`.
- **Table Builder**: Added `Html::table()` for single-line table generation.

## [2.4.4] - 2025-12-14

### Documentation
- **Internationalization**: Added complete English documentation (`README.en.md`, `docs/structure.en.md`).
- **Language Support**: Added language selectors to documentation files.
- **Translations**: Translated all recently added sections (Support, Author, Donations) to Spanish in the main README.

## [2.4.3] - 2025-12-14

### Documentation
- **README Overhaul**: Completely rewrote the documentation to reflect technical architecture, philosophy, and advanced usage patterns in a professional format.

## [2.4.2] - 2025-12-14

### Features
- **Autoload**: Added root `autoload.php` to support manual installation (without Composer). This allows simple `require 'path/to/html/autoload.php'` usage.

## [2.4.1] - 2025-12-14

### Chore
- **Cleanup**: Removed unused root files (`index.php`, `verify_security.php`) to keep the project root clean and professional.

## [2.4.0] - 2025-12-14

### Refactor
- **Source Code**: Moved all source files to `src/` directory to follow standard PSR-4 project structure. Updated `composer.json` autoload accordingly.

### Documentation
- **New Structure**: Added `docs/structure.md` explaining the project layout.
- **Examples**: Added `examples/` directory with functional scripts (`01-basics.php`, `02-forms.php`).
- **README**: Updated with links to examples and documentation.

## [2.3.4] - 2025-12-14

### Infrastructure
- **CI/CD**: Added GitHub Actions workflows for automated testing (`php.yml`) and release generation (`release.yml`).
- **IDE**: Added VS Code configuration (`.vscode/`) including settings and extension recommendations for better developer experience.

## [2.3.3] - 2025-12-14

### Fixed
- **Repository**: Added `.gitignore` and removed `vendor/` directory from version control to prevent dependency bloat.

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
