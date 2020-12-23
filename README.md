# Sessions module for UserFrosting 4

[![Latest Version](https://img.shields.io/github/release/userfrosting/session.svg)](https://github.com/userfrosting/session/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Join the chat at https://chat.userfrosting.com/channel/support](https://chat.userfrosting.com/api/v1/shield.svg?name=UserFrosting)](https://chat.userfrosting.com/channel/support)
[![Donate](https://img.shields.io/badge/Open%20Collective-Donate-blue.svg)](https://opencollective.com/userfrosting#backer)

| Branch | Build | Coverage | Style |
| ------ |:-----:|:--------:|:-----:|
| [master][Session]  | [![][session-master-build]][session-travis] | [![][session-master-codecov]][session-codecov] | [![][session-style-master]][session-style] |
| [develop][session-develop] | [![][session-develop-build]][session-travis] | [![][session-develop-codecov]][session-codecov] | [![][session-style-develop]][session-style] |

<!-- Links -->
[Session]: https://github.com/userfrosting/session
[session-develop]: https://github.com/userfrosting/session/tree/develop
[session-version]: https://img.shields.io/github/release/userfrosting/session.svg
[session-master-build]: https://github.com/userfrosting/session/workflows/Build/badge.svg?branch=master
[session-master-codecov]: https://codecov.io/gh/userfrosting/session/branch/master/graph/badge.svg
[session-develop-build]: https://github.com/userfrosting/session/workflows/Build/badge.svg?branch=develop
[session-develop-codecov]: https://codecov.io/gh/userfrosting/session/branch/develop/graph/badge.svg
[session-releases]: https://github.com/userfrosting/session/releases
[session-travis]: https://github.com/userfrosting/session/actions?query=workflow%3ABuild
[session-codecov]: https://codecov.io/gh/userfrosting/session
[session-style-master]: https://github.styleci.io/repos/60301008/shield?branch=master&style=flat
[session-style-develop]: https://github.styleci.io/repos/60301008/shield?branch=develop&style=flat
[session-style]: https://github.styleci.io/repos/60301008

## Example usage:

```
use Illuminate\Filesystem\Filesystem;
use Illuminate\Session\FileSessionHandler;
use UserFrosting\Session\Session;

// Use custom filesystem sessions
$fs = new FileSystem;
$handler = new FileSessionHandler($fs, \UserFrosting\APP_DIR . "/sessions");

// Creates a new wrapper for $_SESSION
$session = new Session($handler, $config['session']);

// Starts the session
$session->start();

// Set some values
$session['contacts.housekeeper.name']; = 'Alex "the man" Weissman';

// They're stored in array format...
print_r($session->all());

// Output is:
/*
[
    'contacts' => [
        'housekeeper' => [
            'name' => 'Alex "the man" Weissman'
        ]
    ]
];
*/

// Destroy the session, both in memory and on the persistence layer, and tell the browser to remove the cookie
$session->destroy();

```

## [Style Guide](STYLE-GUIDE.md)

## [Testing](RUNNING_TESTS.md)
