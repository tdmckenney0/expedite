<?php
App::uses('TemplateType', 'Templates.Model');

/**
 * TemplateType Test Case
 *
 */
class TemplateTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.templates.template_type',
		'plugin.templates.template'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TemplateType = ClassRegistry::init('Templates.TemplateType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TemplateType);

		parent::tearDown();
	}

}
