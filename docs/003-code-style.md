## Code style

This project is following [PSR-12: Extended Coding Style](https://php-fig.org/psr/psr-12/) standard.

Code style violations are detecting automatically on pre-commit git hook with [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).
Git hooks implemented with the help of the [CaptainHook](https://github.com/captainhookphp/captainhook) project.

Static code analysis is running against the codebase via [PHPStan Level 6 checks](https://phpstan.org/user-guide/rule-levels).

Commits should comply with [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) specification. In the future, it can help handle versioning and changelog in a more automated way.
