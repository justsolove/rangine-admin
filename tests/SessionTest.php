<?php

namespace W7\Tests;

use Illuminate\Filesystem\Filesystem;
use W7\App\Handler\Session\TestHandler;
use W7\Core\Session\Session;
use W7\Http\Message\Server\Request;

class SessionTest extends TestCase {
	public function testSet() {
		$session = new Session();
		$session->start(new Request('GET', '/'));
		$session->set('test', 1);

		$this->assertSame(1, $session->get('test'));
	}

	public function testDestroy() {
		$session = new Session();
		$session->start(new Request('GET', '/'));
		$session->set('test', 1);
		$session->destroy();

		$this->assertSame('', $session->get('test'));
	}

	public function testGc() {
		session_reset();
		$config = iconfig()->getUserConfig('app');
		$config['session'] = [
			'gc_divisor' => 1,
			'gc_probability' => 1,
			'expires' => 1
		];
		iconfig()->setUserConfig('app', $config);

		$session = new Session();
		$sessionReflect = new \ReflectionClass($session);
		$property = $sessionReflect->getProperty('handler');
		$property->setAccessible(true);
		$property->setValue($session, null);

		$session->start(new Request('GET', '/'));
		$session->set('test', 1);

		sleep(2);
		$session->gc();
		$session->gc();

		$property = $sessionReflect->getProperty('cache');
		$property->setAccessible(true);
		$property->setValue($session, null);

		$this->assertSame('', $sessionReflect->getMethod('get')->invokeArgs($session, ['test']));
	}

	public function testUserHandler() {
		$filesystem = new Filesystem();
		$filesystem->copyDirectory(__DIR__ . '/Util/Handler/Session', APP_PATH . '/Handler/Session');

		$config = iconfig()->getUserConfig('app');
		$config['session']['handler'] = 'test';
		iconfig()->setUserConfig('app', $config);

		$session = new Session();
		$sessionReflect = new \ReflectionClass($session);
		$property = $sessionReflect->getProperty('handler');
		$property->setAccessible(true);
		$property->setValue($session, null);

		$session->start(new Request('GET', '/'));
		$session->set('test', 1);

		$this->assertSame(1, $session->get('test'));
		$property = $sessionReflect->getProperty('handler');
		$property->setAccessible(true);
		$handler = $property->getValue($session);
		$this->assertSame(true, $handler instanceof TestHandler);

		$filesystem->deleteDirectory(APP_PATH . '/Handler/Session');
	}
}