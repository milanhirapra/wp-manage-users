<?php

namespace Milan\ManageUsers\Tests;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/**
 * This abstract class will contain some helper methods to easily create mocks.
 */
abstract class AbstractTestCase extends TestCase {


	protected function setUp() {

		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown() {

		Monkey\tearDown();
		parent::tearDown();
	}
}
