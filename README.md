# Sessions module for UserFrosting 4

[![Latest Version](https://img.shields.io/github/release/userfrosting/session.svg)](https://github.com/userfrosting/session/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
<!-- [![Build Status](https://travis-ci.org/userfrosting/session.svg?branch=master)](https://travis-ci.org/userfrosting/session) -->
<!-- [![codecov](https://codecov.io/gh/userfrosting/session/branch/master/graph/badge.svg)](https://codecov.io/gh/userfrosting/session) -->
[![Join the chat at https://chat.userfrosting.com/channel/support](https://demo.rocket.chat/images/join-chat.svg)](https://chat.userfrosting.com/channel/support)
[![Donate](https://img.shields.io/badge/Open%20Collective-Donate-blue.svg)](https://opencollective.com/userfrosting#backer)


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
