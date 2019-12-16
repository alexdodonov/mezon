<?php
require_once (__DIR__ . '/../ok.php');

class OKAuthUnitTest extends PHPUnit\Framework\TestCase
{

    /**
     * Method returns fake settings
     *
     * @return array fake settings
     */
    protected function get_settings(): array
    {
        return ([
            'client_id' => 1,
            'client_secret' => 2,
            'redirect_uri' => 3,
            'client_public' => 4
        ]);
    }

    /**
     * Testing get_user_info_uri
     */
    public function test_get_user_info_uri()
    {
        // setup
        $Auth = new OKAuth($this->get_settings());

        // test body and assertions
        $this->assertContains('/api.odnoklassniki.ru/fb.do?application_key=', $Auth->get_user_info_uri());
        $this->assertContains('?application_key=4', $Auth->get_user_info_uri());
    }

    /**
     * Testing get_token_uri
     */
    public function test_get_token_uri()
    {
        // setup
        $Auth = new OKAuth($this->get_settings());

        // test body and assertions
        $this->assertContains('/api.odnoklassniki.ru/oauth/token.do?grant_type=authorization_code&', $Auth->get_token_uri());
    }

    /**
     * Testing dispatch_user_info
     */
    public function test_dispatch_user_info()
    {
        // setup
        $Auth = new OKAuth($this->get_settings());

        // test body
        $Result = $Auth->dispatch_user_info([
            'uid' => '',
            'first_name' => '',
            'last_name' => '',
            'pic190x190' => '',
            'email' => ''
        ]);

        // assertions
        $this->assertArrayHasKey('id', $Result, 'id was not found');
        $this->assertArrayHasKey('first_name', $Result, 'first_name was not found');
        $this->assertArrayHasKey('last_name', $Result, 'last_name was not found');
        $this->assertArrayHasKey('picture', $Result, 'picture was not found');
        $this->assertArrayHasKey('email', $Result, 'email was not found');
    }

    /**
     * Testing get_token_params method
     */
    public function test_get_token_params()
    {
        // setup
        $Auth = new OKAuth($this->get_settings());

        // test body
        $Params = $Auth->get_token_params(123);

        // assertions
        $this->assertEquals(1, $Params['client_id'], 'Invalid "client_id"');
        $this->assertEquals(2, $Params['client_secret'], 'Invalid "client_secret"');
        $this->assertEquals(3, $Params['redirect_uri'], 'Invalid "redirect_uri"');
        $this->assertEquals('authorization_code', $Params['grant_type'], 'Invalid "grant_type"');
        $this->assertEquals(123, $Params['code'], 'Invalid "code"');
    }
}

?>