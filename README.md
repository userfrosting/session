# Sessions module for UserFrosting 4.1

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