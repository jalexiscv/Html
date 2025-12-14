# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
