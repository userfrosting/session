<?php

/*
 * UserFrosting Session (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/session
 * @copyright Copyright (c) 2013-2019 Alexander Weissman, Louis Charette
 * @license   https://github.com/userfrosting/session/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Session;

use ArrayAccess;
use Illuminate\Session\ExistenceAwareInterface;
use Illuminate\Support\Arr;
use SessionHandlerInterface;

/**
 * A wrapper for $_SESSION that can be used with a variety of different session handlers, based on illuminate/session.
 *
 * @author Alexander Weissman (https://alexanderweissman.com)
 */
class Session implements ArrayAccess
{
    /**
     * The session handler implementation.
     *
     * @var SessionHandlerInterface
     */
    protected $handler;

    /**
     * Create the session wrapper.
     *
     * @param SessionHandlerInterface|null $handler
     * @param array                        $config
     */
    public function __construct(SessionHandlerInterface $handler = null, array $config = [])
    {
        $this->handler = $handler;

        if ($this->status() == PHP_SESSION_NONE) {
            if ($handler) {
                session_set_save_handler($handler, true);
            }

            if (isset($config['cache_limiter'])) {
                session_cache_limiter($config['cache_limiter']);
            }

            if (isset($config['cache_expire'])) {
                session_cache_expire($config['cache_expire']);
            }

            if (isset($config['name'])) {
                session_name($config['name']);
            }

            if (isset($config['cookie_parameters'])) {
                session_set_cookie_params($config['cookie_parameters']);
            }
        }
    }

    /**
     * Returns the current session status.
     *
     * @return int PHP_SESSION_DISABLED | PHP_SESSION_NONE | PHP_SESSION_ACTIVE
     */
    public function status()
    {
        return session_status();
    }

    /**
     * Start the session.
     */
    public function start()
    {
        if ($this->status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Destroy the current session, and unset all values in memory.  Destroy the session cookie as well to remove all traces client-side.
     *
     * @param bool $destroyCookie Destroy the cookie on the client side as well.
     */
    public function destroy($destroyCookie = true)
    {
        if ($this->status() == PHP_SESSION_NONE) {
            return;
        }

        session_unset();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if ($destroyCookie && ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();
    }

    /**
     * Regenerate the session id.  For example, when logging someone in, you should regenerate the session to prevent session fixation attacks.
     *
     * @param bool $deleteOldSession Set to true when you are logging someone in.
     */
    public function regenerateId($deleteOldSession = false)
    {
        session_regenerate_id($deleteOldSession);

        $this->setExists(false);
    }

    /**
     * Get the current session id.
     *
     * @return string
     */
    public function getId()
    {
        return session_id();
    }

    /**
     * Determine if the given session value exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($_SESSION, $key);
    }

    /**
     * Get the specified session value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($_SESSION, $key, $default);
    }

    /**
     * Set a given session value.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($_SESSION, $innerKey, $innerValue);
            }
        } else {
            Arr::set($_SESSION, $key, $value);
        }
    }

    /**
     * Set the existence of the session on the handler if applicable.
     *
     * @param bool $value
     */
    public function setExists($value)
    {
        if ($this->handler instanceof ExistenceAwareInterface) {
            $this->handler->setExists($value);
        }
    }

    /**
     * Prepend a value onto an array session value.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
     * Push a value onto an array session value.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function push($key, $value)
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * Get all of the session items for the application.
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION;
    }

    /**
     * Determine if the given session option exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get a session option.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a session option.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset a session option.
     *
     * @param string $key
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }

    /**
     * @return SessionHandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }
}
