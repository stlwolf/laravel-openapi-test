<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenAPIValidation\PSR7\OperationAddress;
use Tests\TestCase;
use OpenAPIValidation\PSR7\ValidatorBuilder;
use Illuminate\Testing\TestResponse;
use Nyholm\Psr7\Factory\Psr17Factory;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    protected $openApiSpec;

    protected function setUp(): void
    {
        parent::setUp();
        $this->openApiSpec = __DIR__ . '/../../../app/openapi.yml';
    }

    public function testPostApi()
    {
        // Create a new post
        $postData = [
            'title' => 'テストタイトル',
            'content' => 'テストコンテンツ',
        ];
        $response = $this->postJson('/api/posts', $postData);
        $response->assertStatus(201);

        // Validate the response against the OpenAPI spec
        $this->validateResponse('/api/posts', 'post', $response);

        // Update the post
        $postId = $response->json('id');
        $updateData = [
            'title' => '更新されたタイトル',
            'content' => '更新されたコンテンツ',
        ];
        $response = $this->putJson("/api/posts/{$postId}", $updateData);
        $response->assertStatus(200);

        // Validate the response against the OpenAPI spec
        $this->validateResponse('/api/posts/{id}', 'put', $response);

        // Delete the post
        $response = $this->deleteJson("/api/posts/{$postId}");
        $response->assertStatus(204);

        // Validate the response against the OpenAPI spec
        $this->validateResponse('/api/posts/{id}', 'delete', $response);
    }

    protected function validateResponse(string $path, string $method, TestResponse $laravelResponse)
    {
        // Convert Laravel TestResponse to PSR-7 ResponseInterface
        $psr17Factory = new Psr17Factory();
        $psr7Response = $psr17Factory->createResponse($laravelResponse->status());
        foreach ($laravelResponse->headers->all() as $name => $values) {
            $psr7Response = $psr7Response->withHeader($name, $values);
        }
        $psr7Response->getBody()->write($laravelResponse->content());

        // Validate the response against the OpenAPI spec
        $validator = (new ValidatorBuilder())->fromYamlFile($this->openApiSpec)->getResponseValidator();
        $operationAddress = new OperationAddress($path, $method);
        $validator->validate($operationAddress, $psr7Response);
    }
}
