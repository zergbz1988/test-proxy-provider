<?php

namespace Tests\Feature;

use App\Models\User;
use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProxiesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testProxiesListUnauthorized(): void
    {
        $response = $this->post('/proxies/list');

        $response->assertStatus(401);
    }

    public function testProxiesListSuccess(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/proxies/list');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['ip', 'port', 'login', 'password']
        ]);
    }

    public function testProxiesExportUnauthorized(): void
    {
        $response = $this->post('/proxies/export');

        $response->assertStatus(401);
    }

    /**
     * @dataProvider proxiesExportInvalidRequestsDataProvider
     */
    public function testProxiesExportInvalidRequests(string $format): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/proxies/export', ['format' => $format]);

        $response->assertStatus(400);
        $response->assertJson([
            'code' => 'validation_error'
        ]);
    }

    public function proxiesExportInvalidRequestsDataProvider(): array
    {
        return [
            'empty format' => [''],
            'invalid format' => ['port'],
        ];
    }

    /**
     * @dataProvider proxiesExportSuccessDataProvider
     */
    public function testProxiesExportSuccess(string $format, Closure $testValue): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/proxies/export', ['format' => $format]);

        $response->assertStatus(200);
        $content = $response->streamedContent();
        $contentArray = explode("\n", $content);
        array_pop($contentArray);
        $this->assertEquals('Proxy', array_shift($contentArray));
        foreach ($contentArray as $proxyString) {
            $this->assertTrue($testValue($proxyString));
        }
    }

    public function proxiesExportSuccessDataProvider(): array
    {
        return [
            'ip' => ['ip', fn(string $value) => filter_var($value, FILTER_VALIDATE_IP) !== false],
            'ip:port' => [
                'ip:port',
                function (string $value) {
                    $separatorPos = strrpos($value, ':');
                    $port = substr($value, $separatorPos + 1);
                    $portIsValid = is_numeric($port);
                    $ip = substr($value, 0, $separatorPos);
                    $ipIsValid = filter_var($ip, FILTER_VALIDATE_IP) !== false;

                    return $portIsValid && $ipIsValid;
                }
            ],
            'ip@login:password' => [
                'ip@login:password',
                function (string $value) {
                    $separatorPos = strrpos($value, ':');
                    $dogSymbolPos = strrpos($value, '@');
                    $password = substr($value, $separatorPos + 1);
                    $login = substr($value, $dogSymbolPos + 1, $separatorPos - $dogSymbolPos - 1);
                    $ip = substr($value, 0, $dogSymbolPos);
                    $ipIsValid = filter_var($ip, FILTER_VALIDATE_IP) !== false;

                    return $ipIsValid && !empty($login) && !empty($password);
                }
            ],
            'full' => [
                'ip:port@login:password',
                function (string $value) {
                    $parts = explode('@', $value);

                    $separatorPos = strrpos($parts[0], ':');
                    $port = substr($parts[0], $separatorPos + 1);
                    $portIsValid = is_numeric($port);
                    $ip = substr($parts[0], 0, $separatorPos);
                    $ipIsValid = filter_var($ip, FILTER_VALIDATE_IP) !== false;

                    $separatorPos = strrpos($parts[1], ':');
                    $password = substr($parts[1], $separatorPos + 1);
                    $login = substr($parts[1], 0, $separatorPos);

                    return $ipIsValid && $portIsValid && !empty($login) && !empty($password);
                }
            ],
        ];
    }

}
