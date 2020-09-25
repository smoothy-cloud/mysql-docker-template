<?php

namespace Tests;

use Illuminate\Support\Str;
use PDO;
use SmoothyCloud\ApplicationTemplateValidator\Testing\TemplateTest;

class Test extends TemplateTest
{
    /** @test */
    public function the_syntax_of_the_template_is_correct()
    {
        $this->validateTemplate();
    }

    /** @test */
    public function the_mysql_5_7_application_works_correctly_when_deployed()
    {
        $variables = [
            'mysql_version' => '5.7',
            'mysql_root_password' => 'secret',
            'memory' => '2048',
            'cpus' => '1000',
        ];

        $services = $this->deployApplication($variables);
        sleep(30);

        $pdo = new PDO("mysql:host=127.0.0.1;port={$services['mysql']}", "root", "secret");
        $version = $pdo->query("SELECT VERSION()")->fetch();
        $this->assertTrue(Str::startsWith($version[0], '5.7'));
    }

    /** @test */
    public function the_mysql_8_application_works_correctly_when_deployed()
    {
        $variables = [
            'mysql_version' => '8.0',
            'mysql_root_password' => 'secret',
            'memory' => '2048',
            'cpus' => '1000',
        ];

        $services = $this->deployApplication($variables);
        sleep(30);

        $pdo = new PDO("mysql:host=127.0.0.1;port={$services['mysql']}", "root", "secret");
        $version = $pdo->query("SELECT VERSION()")->fetch();
        $this->assertTrue(Str::startsWith($version[0], '8.0'));
    }
}
