# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [4.3.0]
- Added additional configuration option `cookie_parameters`

## [4.2.0]
- Bump version for UF 4.2
- Moved code from `session/` to `src/`

## [4.1.0]
- Bump version for UF 4.1

## [4.0.1]
- Set session existence to false in handler upon regeneration. This tells Laravel's session handlers (in particular, the DB handler) that it needs to write a new session rather than trying to update the session for the old session id.

## 4.0.0
- First release


[4.2.0]: https://github.com/userfrosting/session/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/userfrosting/session/compare/4.0.1...4.1.0
[4.0.1]: https://github.com/userfrosting/session/compare/4.0.0...4.0.1
