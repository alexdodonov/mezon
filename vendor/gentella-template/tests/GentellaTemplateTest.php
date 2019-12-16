<?php
require_once (__DIR__ . '/../gentella-template.php');

class GentellaTemplateTest extends PHPUnit\Framework\TestCase
{

    /**
     * Testing message content.
     */
    public function testSuccessMessageContent()
    {
        $Str1 = GentellaTemplate::success_message_content('msg');
        $Str2 = '<div class="x_content" style="margin: 0; padding: 0;">' . '<div class="alert alert-success alert-dismissible fade in" role="alert">' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' . '<span aria-hidden="true">×</span></button>msg</div></div>';

        $this->assertEquals($Str1, $Str2, 'Invalid HTML');
    }

    /**
     * Testing message content.
     */
    public function testWarningMessageContent()
    {
        $Str1 = GentellaTemplate::warning_message_content('msg');
        $Str2 = '<div class="x_content" style="margin: 0; padding: 0;">' . '<div class="alert alert-warning alert-dismissible fade in" role="alert">' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' . '<span aria-hidden="true">×</span></button>msg</div></div>';

        $this->assertEquals($Str1, $Str2, 'Invalid HTML');
    }

    /**
     * Testing message content.
     */
    public function testInfoMessageContent()
    {
        $Str1 = GentellaTemplate::info_message_content('msg');
        $Str2 = '<div class="x_content" style="margin: 0; padding: 0;">' . '<div class="alert alert-info alert-dismissible fade in" role="alert">' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' . '<span aria-hidden="true">×</span></button>msg</div></div>';

        $this->assertEquals($Str1, $Str2, 'Invalid HTML');
    }

    /**
     * Testing message content.
     */
    public function testDangerMessageContent()
    {
        $Str1 = GentellaTemplate::danger_message_content('msg');
        $Str2 = '<div class="x_content" style="margin: 0; padding: 0;">' . '<div class="alert alert-danger alert-dismissible fade in" role="alert">' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' . '<span aria-hidden="true">×</span></button>msg</div></div>';

        $this->assertEquals($Str1, $Str2, 'Invalid HTML');
    }
}

?>