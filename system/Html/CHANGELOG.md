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
