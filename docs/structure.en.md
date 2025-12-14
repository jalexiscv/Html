# Project Structure

Starting from version 2.4.0, **Higgs HTML** adopts a modern directory structure compatible with the PSR-4 standard of the PHP community.

## Directories

### `src/` (Source)
Contains all the library's source code (Classes, Interfaces, Traits).
*   **Convention**: Folder names within `src/` exactly match the namespace (`PascalCase`).
*   **Example**: The `Higgs\Html\Tag\AbstractTag` class is located at `src/Tag/AbstractTag.php`.

### `examples/`
Contains executable PHP scripts that demonstrate real-world use cases of the library.
*   Designed for new developers to copy and paste functional code.

### `docs/`
Extended documentation in Markdown format.

### `tests/`
Unit tests (PHPUnit) to ensure code stability.

### `vendor/`
Dependencies managed by Composer (not committed to the repository).

## Why this change?
Keeping source code separate from documentation and root configuration (`src/` vs root) improves organization, facilitates navigation, and prevents the Composer autoloader from scanning unnecessary files.
