<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    private static $firstRun = true;

    protected function setUp(): void
    {
        parent::setUp();

        if (self::$firstRun) {
            file_put_contents(public_path('login-test-report.html'), '');
            self::$firstRun = false;
        }
    }

    public function test_login_success()
    {
        $response = $this->post('/login', [
            'email' => 'valid@example.com',
            'password' => 'validpassword',
        ]);

        $status = $response->getStatusCode();
        $expectedType = 'Integer';
        $actualType = ucfirst(gettype($status));
        $result = ($status === 200) ? 'Passed' : 'Failed';
        $title = $result === 'Passed'
            ? '✅ Unit Test: Login with Valid Credentials Passed'
            : '❌ Unit Test: Login with Valid Credentials Failed';
        $line = __LINE__;
        $file = __FILE__;

        $html = $this->generateHtmlTable(
            $title,
            'Login with valid credentials',
            $actualType,
            $expectedType,
            $result,
            $file,
            $line
        );

        file_put_contents(public_path('login-test-report.html'), $html, FILE_APPEND);
        $this->assertTrue($status === 200);
    }

    public function test_login_fail()
    {
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $status = $response->getStatusCode();
        $expectedType = 'Integer';
        $actualType = ucfirst(gettype($status));
        $result = ($status !== 200) ? 'Passed' : 'Failed';
        $title = $result === 'Passed'
            ? '✅ Unit Test: Login with Invalid Credentials Passed'
            : '❌ Unit Test: Login with Invalid Credentials Failed';
        $line = __LINE__;
        $file = __FILE__;

        $html = $this->generateHtmlTable(
            $title,
            'Login with invalid credentials',
            $actualType,
            $expectedType,
            $result,
            $file,
            $line
        );

        file_put_contents(public_path('login-test-report.html'), $html, FILE_APPEND);
        $this->assertTrue($status !== 200);
    }

    private function generateHtmlTable($title, $testName, $actualType, $expectedType, $result, $file, $line)
    {
        $color = $result === 'Passed' ? 'green' : 'red';

        return "
        <table border='1' style='width: 90%; margin: 20px auto; border-collapse: collapse;'>
            <tr><th colspan='2' style='padding: 10px; font-size: 18px;'>$title</th></tr>
            <tr><td><b>Test Name</b></td><td>$testName</td></tr>
            <tr><td><b>Test Datatype</b></td><td>$actualType</td></tr>
            <tr><td><b>Expected Datatype</b></td><td>$expectedType</td></tr>
            <tr><td><b>Result</b></td><td style='color: $color; font-weight:bold;'>$result</td></tr>
            <tr><td><b>File Name</b></td><td>$file</td></tr>
            <tr><td><b>Line Number</b></td><td>$line</td></tr>
            <tr><td><b>Notes</b></td><td></td></tr>
        </table>\n";
    }
}
