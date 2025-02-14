<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Http\Controllers\ProductController;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductControllerTest extends TestCase
{
    protected $productRepository;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Criando um mock do ProductRepository
        $this->productRepository = Mockery::mock(ProductRepository::class);

        // Criando uma instância do controller com o repositório mockado
        $this->controller = new ProductController($this->productRepository);
    }

    public function test_list_returns_json_response()
    {
        $this->productRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn(['product1', 'product2']);

        $response = $this->controller->list();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['product1', 'product2']), $response->getContent());
    }

    public function test_create_returns_created_product()
    {
        $request = new Request(['name' => 'Laptop', 'price' => 2500]);

        $this->productRepository
            ->shouldReceive('create')
            ->once()
            ->with($request->all())
            ->andReturn(['id' => 1, 'name' => 'Laptop', 'price' => 2500]);

        $response = $this->controller->create($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['id' => 1, 'name' => 'Laptop', 'price' => 2500]), $response->getContent());
    }

    public function test_show_returns_product_data()
    {
        $this->productRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn(['id' => 1, 'name' => 'Laptop', 'price' => 2500]);

        $response = $this->controller->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['id' => 1, 'name' => 'Laptop', 'price' => 2500]), $response->getContent());
    }

    public function test_update_updates_product()
    {
        $request = new Request(['name' => 'Laptop Pro', 'price' => 3000]);

        $this->productRepository
            ->shouldReceive('update')
            ->once()
            ->with(1, $request->all())
            ->andReturn(['id' => 1, 'name' => 'Laptop Pro', 'price' => 3000]);

        $response = $this->controller->update($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['id' => 1, 'name' => 'Laptop Pro', 'price' => 3000]), $response->getContent());
    }

    public function test_delete_removes_product()
    {
        $this->productRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $response = $this->controller->delete(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['deleted' => true]), $response->getContent());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
