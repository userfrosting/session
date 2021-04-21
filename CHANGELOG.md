# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [4.5.0]
- Version bump

## [4.4.1]
- Replaced Travis with GitHub Action for build

## [4.4.0]
- Version bump

## [4.3.0]
- Dropping support for PHP 5.6 & 7.0
- Updated dependencies
- Updated PHPUnit to 7.5

## [4.2.2]
- Added `getHandler` to the Session class for easier testing

## [4.2.1]
- Added additional configuration option `cookie_parameters` ([#4])
- Added `getId` method.
- Added `status` method.
- Destroying an uninitialized session won't generate an error.
- Added automated tests.

## [4.2.0]
- Bump version for UF 4.2
- Moved code from `session/` to `src/`

## [4.1.0]
- Bump version for UF 4.1

## [4.0.1]
- Set session existence to false in handler upon regeneration. This tells Laravel's session handlers (in particular, the DB handler) that it needs to write a new session rather than trying to update the session for the old session id.

## 4.0.0
- First release


[#4]: https://github.com/userfrosting/session/pull/4
[4.4.1]: https://github.com/userfrosting/session/compare/4.4.1...4.5.0
[4.4.1]: https://github.com/userfrosting/session/compare/4.4.0...4.4.1
[4.4.0]: https://github.com/userfrosting/session/compare/4.3.0...4.4.0
[4.3.0]: https://github.com/userfrosting/session/compare/4.2.2...4.3.0
[4.2.2]: https://github.com/userfrosting/session/compare/4.2.1...4.2.2
[4.2.1]: https://github.com/userfrosting/session/compare/4.2.0...4.2.1
[4.2.0]: https://github.com/userfrosting/session/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/userfrosting/session/compare/4.0.1...4.1.0
[4.0.1]: https://github.com/userfrosting/session/compare/4.0.0...4.0.1
