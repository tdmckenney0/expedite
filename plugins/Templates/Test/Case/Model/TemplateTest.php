<?php
App::uses('Template', 'Templates.Model');

/**
 * Template Test Case
 *
 */
class TemplateTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.templates.template',
		'plugin.templates.template_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Template = ClassRegistry::init('Templates.Template');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Template);

		parent::tearDown();
	}

}
