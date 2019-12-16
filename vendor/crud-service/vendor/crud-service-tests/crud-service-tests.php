<?php
/**
 * Class CRUDServiceTests
 *
 * @package     CRUDService
 * @subpackage  CRUDServiceTests
 * @author      Dodonov A.A.
 * @version     v.1.0 (2019/08/17)
 * @copyright   Copyright (c) 2019, aeon.org
 */
require_once (__DIR__ . '/../../../service/vendor/service-tests/service-tests.php');

/**
 * Predefined set of tests for crud service.
 *
 * @author Dodonov A.A.
 */
class CRUDServiceTests extends ServiceTests
{

	/**
	 * Method tests list endpoint.
	 */
	public function test_list()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/list/?from=0&limit=20';

		$Result = $this->get_html_request($URL);

		$this->assertEquals(count($Result) > 0, true, 'No records were returned');
	}

	/**
	 * Method tests cross domain list endpoint.
	 */
	public function test_cross_domain_list()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/list/?from=0&limit=20&cross_domain=1';

		$Result = $this->get_html_request($URL);

		$this->assertEquals(count($Result) > 0, true, 'No records were listed');
	}

	/**
	 * Method tests non cross domain list endpoint.
	 */
	public function test_non_cross_domain_list()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/list/?from=0&limit=20&cross_domain=0';

		$Result = $this->get_html_request($URL);

		$this->assertEquals(count($Result) > 0, true, 'No records were listed');
	}

	/**
	 * Method tests records counter.
	 */
	public function test_records_count()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/records/count/';

		$Result = $this->get_html_request($URL);

		$this->assertEquals($Result > 0, true, 'Invalid records counting (>0)');
	}

	/**
	 * Method tests list page endpoint.
	 */
	public function test_list_page()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/list/page/';

		$Result = $this->get_html_request($URL);

		$this->assertTrue(isset($Result->main), 'Page view was not generated');
	}

	/**
	 * Method tests last records fetching.
	 */
	public function test_last_records2()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/last/2/';

		$Result = $this->get_html_request($URL);

		$this->assertEquals(count($Result) > 0, true, 'Invalid records counting (2)');
	}

	/**
	 * Method tests last records fetching.
	 */
	public function test_last_records0()
	{
		$this->valid_connect();

		$URL = $this->ServerPath . '/last/0/';

		$Result = $this->get_html_request($URL);

		$this->assertEquals(count($Result), 0, 'Invalid records counting (0)');
	}
}

?>