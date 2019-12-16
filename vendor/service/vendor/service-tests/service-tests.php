<?php

/**
 * Class ServiceTests
 *
 * @package     Service
 * @subpackage  ServiceTests
 * @author      Dodonov A.A.
 * @version     v.1.0 (2019/08/17)
 * @copyright   Copyright (c) 2019, aeon.org
 */

require_once(__DIR__.'/../../../functional/functional.php');
require_once(__DIR__.'/../service-client/service-client.php');

/**
 * Predefined set of tests for service.
 */
class ServiceTests extends PHPUnit\Framework\TestCase
{

	/**
	 * Session id.
	 */
	var $SessionId = false;

	/**
	 * Server path.
	 */
	var $ServerPath = false;

	/**
	 * Headers.
	 *
	 * @var string
	 */
	var $Headers = false;

	/**
	 * Constructor.
	 *
	 * @param string $Service
	 *        	- Service name.
	 */
	public function __construct(string $Service)
	{
		parent::__construct();

		$this->ServerPath = DNS::resolve_host($Service);
	}

	/**
	 * Method asserts for errors and warnings in the html code.
	 *
	 * @param string $Content
	 *        	- Asserting content.
	 * @param string $Message
	 *        	- Message to be displayed in case of error.
	 */
	protected function assert_errors($Content, $Message)
	{
		if (strpos($Content, 'Warning') !== false || strpos($Content, 'Error') !== false || strpos($Content, 'Fatal error') !== false || strpos($Content, 'Access denied') !== false || strpos($Content, "doesn't exist in statement") !== false) {
			throw (new Exception($Message . "\r\n" . $Content));
		}

		$this->addToAssertionCount(1);
	}

	/**
	 * Method asserts JSON.
	 *
	 * @param mixed $JSONResult
	 *        	- Result of the call;
	 * @param string $Result
	 *        	- Raw result of the call.
	 */
	protected function assert_json($JSONResult, string $Result)
	{
		if ($JSONResult === null && $Result !== '') {
			throw (new Exception("JSON result is invalid because of:\r\n$Result"));
		}

		if (isset($JSONResult->message)) {
			throw (new Exception($JSONResult->message, $JSONResult->code));
		}
	}

	/**
	 * Method sends post request.
	 *
	 * @param array $Data
	 *        	- Request data;
	 * @param string $URL
	 *        	- Requesting endpoint.
	 * @return mixed Request result.
	 */
	protected function post_http_request(array $Data, string $URL)
	{
		$Options = [
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0\r\n" . ($this->SessionId !== false ? "Cgi-Authorization: Basic " . $this->SessionId . "\r\n" : '') . ($this->Headers !== false ? implode("\r\n", $this->Headers) . "\r\n" : ''),
				'method' => 'POST',
				'content' => http_build_query($Data)
			]
		];

		$Context = stream_context_create($Options);
		$Result = file_get_contents($URL, false, $Context);

		$this->assert_errors($Result, 'Request have returned warnings/errors');

		$JSONResult = json_decode($Result);

		$this->assert_json($JSONResult, $Result);

		return ($JSONResult);
	}

	/**
	 * Method prepares GET request options.
	 */
	protected function prepare_get_options()
	{
		$Options = [
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0\r\n" . ($this->SessionId !== false ? "Cgi-Authorization: Basic " . $this->SessionId . "\r\n" : '') . ($this->Headers !== false ? implode("\r\n", $this->Headers) . "\r\n" : ''),
				'method' => 'GET'
			]
		];

		return ($Options);
	}

	/**
	 * Method sends GET request
	 *
	 * @param string $URL
	 *        	Requesting URL
	 * @return mixed Result off the request
	 */
	protected function get_html_request(string $URL)
	{
		$Options = $this->prepare_get_options();

		$Context = stream_context_create($Options);
		$Result = file_get_contents($URL, false, $Context);

		$this->assert_errors($Result, 'Request have returned warnings/errors');

		$JSONResult = json_decode($Result);

		$this->assert_json($JSONResult, $Result);

		return ($JSONResult);
	}

	/**
	 * Method returns test data
	 *
	 * @return array Test data
	 */
	protected function get_user_data(): array
	{
		return ([
			'login' => 'alexey@dodonov.pro',
			'password' => 'root'
		]);
	}

	/**
	 * Method performs valid connect.
	 *
	 * @return mixed Result of the connection.
	 */
	protected function valid_connect()
	{
		$Data = $this->get_user_data();

		$URL = $this->ServerPath . '/connect/';

		$Result = $this->post_http_request($Data, $URL);

		if (isset($Result->session_id) !== false) {
			$this->SessionId = $Result->session_id;
		}

		return ($Result);
	}

	/**
	 * Testing API connection.
	 */
	public function test_valid_connect()
	{
		// authorization
		$Result = $this->valid_connect();

		$this->assertNotEquals($Result, null, 'Connection failed');

		if (isset($Result->session_id) === false) {
			$this->assertEquals(true, false, 'Field "session_id" was not set');
		}

		$this->SessionId = $Result->session_id;
	}

	/**
	 * Testing API invalid connection.
	 */
	public function test_invalid_connect()
	{
		try {
			// authorization
			$Data = $this->get_user_data();
			$Data['password'] = '1234';

			$URL = $this->ServerPath . '/connect/';

			$this->post_http_request($Data, $URL);

			$this->fail('Exception was not thrown');
		} catch (Exception $e) {
			$this->assertEquals('User with login "alexey@dodonov.pro" and ' . 'password "1234" was not found', $e->getMessage(), 'Invalid error message');
			$this->assertEquals(- 1, $e->getCode(), 'Invalid error code');
		}
	}

	/**
	 * Testing setting valid token.
	 */
	public function test_set_valid_token()
	{
		$this->test_valid_connect();

		$Data = [
			'token' => $this->SessionId
		];

		$URL = $this->ServerPath . '/token/' . $this->SessionId . '/';

		$Result = $this->post_http_request($Data, $URL);

		$this->assertEquals(isset($Result->session_id), true, 'Connection failed');
	}

	/**
	 * Testing setting invalid token.
	 */
	public function test_set_invalid_token()
	{
		try {
			$this->test_valid_connect();

			$Data = [
				'token' => ''
			];

			$URL = $this->ServerPath . '/token/unexisting/';

			$this->post_http_request($Data, $URL);
		} catch (Exception $e) {
			// set token method either throws exception or not
			// both is correct behaviour
			$this->assertEquals($e->getMessage(), 'Invalid session token', 'Invalid error message');
			$this->assertEquals($e->getCode(), 2, 'Invalid error code');
		}
	}

	/**
	 * Testing login under another user
	 */
	public function test_login_as()
	{
		// setup
		$this->test_valid_connect();

		// test body
		$Data = [
			'login' => 'alexey@dodonov.none'
		];

		$URL = $this->ServerPath . '/login-as/';

		$this->post_http_request($Data, $URL);

		// assertions
		$URL = $this->ServerPath . '/self/login/';

		$Result = $this->get_html_request($URL);

		$this->assertEquals('alexey@dodonov.none', Functional::get_field($Result, 'login'), 'Session user must be alexey@dodonov.none');
	}
}

?>