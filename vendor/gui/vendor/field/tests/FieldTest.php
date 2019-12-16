<?php
require_once (__DIR__ . '/../field.php');

class FieldTest extends PHPUnit\Framework\TestCase
{

	/**
	 * Testing constructor
	 */
	public function test_no_name_exception()
	{
		try {
			// test body
			$Field = new Field([],'');

			$this->fail('Exception was not thrown ' . serialize($Field));
		} catch (Exception $e) {
			$this->addToAssertionCount(1);
		}
	}

	/**
	 * Testing setters
	 */
	public function test_name_setter()
	{
		// test body
		$Field = new Field(json_decode(file_get_contents(__DIR__ . '/conf/name-setter.json'), true),'');

		// assertions
		$this->assertContains('prefixfield-name000', $Field->html(), 'Invalid field "name" value');
	}

	/**
	 * Testing setters
	 */
	public function test_required_setter()
	{
		// test body
		$Field = new Field(json_decode(file_get_contents(__DIR__ . '/conf/required-setter.json'), true),'');

		// assertions
		$this->assertContains('prefixfield-name1111select2', $Field->html(), 'Invalid field "name" value');
	}
}

?>