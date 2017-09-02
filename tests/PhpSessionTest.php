<?php

namespace Middlewares\Tests;

use PHPUnit\Framework\TestCase;
use Middlewares\PhpSession;
use Middlewares\Utils\Dispatcher;

class PhpSessionTest extends TestCase
{
    public function sessionDataProvider()
    {
        return [
            [
                'session_1',
                'Iván',
            ], [
                'session_2',
                'Pablo',
            ],
        ];
    }

    /**
     * @dataProvider sessionDataProvider
     */
    public function testPhpSession($sessionName, $value)
    {
        $response = Dispatcher::run([
            (new PhpSession())->name($sessionName),
            function ($request) use ($value) {
                echo session_name();

                $_SESSION['name'] = $value;
            },
        ]);

        $this->assertEquals($sessionName, (string) $response->getBody());
        $this->assertEquals($value, $_SESSION['name']);
    }
}