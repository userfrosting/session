<?php

/*
 * UserFrosting Session (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/session
 * @copyright Copyright (c) 2013-2019 Alexander Weissman, Louis Charette
 * @license   https://github.com/userfrosting/session/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Session\Tests;

use Illuminate\Session\ExistenceAwareInterface;
use PHPUnit\Framework\TestCase;
use SessionHandlerInterface;
use UserFrosting\Session\Session;

class SessionTest extends TestCase
{
    /**
     * @var NullSessionHandlerStub
     */
    protected $handler;

    public function setUp()
    {
        $this->handler = new NullSessionHandlerStub();
    }

    /**
     * Test constructor.
     *
     * @return Session
     */
    public function testConstructor()
    {
        $session = new Session($this->handler, $this->sessionConfig());
        $this->assertInstanceOf(Session::class, $session);

        return $session;
    }

    /**
     * @depends testConstructor
     *
     * @param Session $session
     */
    public function testSessionStart(Session $session)
    {
        $this->assertSame(PHP_SESSION_NONE, $session->status());
        $this->assertNull($session->start());
        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());

        return $session;
    }

    /**
     * @depends testSessionStart
     */
    public function testSessionDestroy()
    {
        $session = $this->getSession();

        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());
        $this->assertNull($session->destroy(false));
        $this->assertSame(PHP_SESSION_NONE, $session->status());
    }

    /**
     * @depends testSessionStart
     */
    public function testSessionDestroyWithDestroyCookie()
    {
        $session = $this->getSession();

        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());
        $this->assertNull($session->destroy());
        $this->assertSame(PHP_SESSION_NONE, $session->status());
    }

    /**
     * @depends testSessionStart
     */
    public function testSessionRegenerateId()
    {
        $session = $this->getSession();

        $id = $session->getId();
        $session->regenerateId();
        $newId = $session->getId();

        $this->assertNotSame($id, $newId);
    }

    /**
     * @depends testSessionStart
     */
    public function testSessionStorage()
    {
        $session = $this->getSession();

        $this->assertFalse($session->has('foo'));
        $this->assertNull($session->set('foo', 'bar'));
        $this->assertTrue($session->has('foo'));
        $this->assertSame('bar', $session->get('foo'));
    }

    /**
     * Same as `testSessionStorage`, but for `offsetExists`, `offsetGet` & `offsetSet`.
     *
     * @depends testSessionStart
     * @depends testSessionStorage
     */
    public function testSessionStorageWithOffset()
    {
        $session = $this->getSession();

        $this->assertFalse($session->offsetExists('foo'));
        $this->assertNull($session->offsetSet('foo', 'bar'));
        $this->assertTrue($session->offsetExists('foo'));
        $this->assertSame('bar', $session->offsetGet('foo'));
    }

    /**
     * @depends testSessionStart
     * @depends testSessionStorage
     */
    public function testSessionStorageSet()
    {
        $session = $this->getSession();

        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        $this->assertFalse($session->has('foo'));
        $session->set($data);
        $this->assertTrue($session->has('foo'));
        $this->assertSame('bar', $session->get('foo'));
    }

    /**
     * @depends testSessionStart
     * @depends testSessionStorageSet
     */
    public function testSessionStoragePush()
    {
        $session = $this->getSession();

        $data = [
            'foo',
            'bar',
        ];

        $session->set('data', $data);

        $this->assertCount(2, $session->get('data'));
        $this->assertNull($session->push('data', 'blah'));
        $this->assertCount(3, $session->get('data'));
        $this->assertSame('blah', $session->get('data')[2]);
    }

    /**
     * @depends testSessionStart
     * @depends testSessionStorageSet
     */
    public function testSessionStoragePrepend()
    {
        $session = $this->getSession();

        $data = [
            'foo',
            'bar',
        ];

        $this->assertNull($session->set('data', $data));

        $this->assertCount(2, $session->get('data'));
        $this->assertNull($session->prepend('data', 'blah'));
        $this->assertCount(3, $session->get('data'));
        $this->assertSame('blah', $session->get('data')[0]);
    }

    /**
     * @depends testSessionStart
     * @depends testSessionStorageSet
     */
    public function testSessionStorageAll()
    {
        $session = $this->getSession();

        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        $session->set($data);

        $this->assertSame($data, $session->all());
    }

    /**
     * @depends testSessionStorageWithOffset
     */
    public function testSessionStorageOffsetUnset()
    {
        $session = $this->getSession();

        $session->offsetSet('foo', 'bar');
        $this->assertTrue($session->offsetExists('foo'));
        $this->assertNull($session->offsetUnset('foo'));
        $this->assertNull($session->offsetGet('foo'));
    }

    /**
     * @depends testSessionRegenerateId
     */
    public function testSetExistsWithExistenceAware()
    {
        $handler = new ExistenceAwareNullSessionHandlerStub();
        $session = new Session($handler, $this->sessionConfig());

        $this->assertNull($session->setExists(true));
        $this->assertTrue($handler->getExists());
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        $session = new Session($this->handler, $this->sessionConfig());
        $session->destroy();
        $session->start();

        return $session;
    }

    /**
     * @return array
     */
    protected function sessionConfig()
    {
        return [
            'cache_limiter'     => false,
            'cache_expire'      => 180,
            'name'              => 'sessionTests',
            'cookie_parameters' => 180,
        ];
    }
}

/**
 * Stub Session Handler.
 */
class NullSessionHandlerStub implements SessionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($lifetime)
    {
        return true;
    }
}

class ExistenceAwareNullSessionHandlerStub extends NullSessionHandlerStub implements ExistenceAwareInterface
{
    /**
     * @var bool
     */
    protected $exists;

    public function setExists($value)
    {
        $this->exists = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getExists()
    {
        return $this->exists;
    }
}
