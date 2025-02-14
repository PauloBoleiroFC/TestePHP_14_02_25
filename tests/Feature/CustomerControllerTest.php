<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Http\Controllers\CustomerController;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerControllerTest extends TestCase
{
    protected $customerRepository;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Criando um mock do CustomerRepository
        $this->customerRepository = Mockery::mock(CustomerRepository::class);

        // Criando uma instância do controller com o repositório mockado
        $this->controller = new CustomerController($this->customerRepository);
    }

    public function test_list_returns_json_response()
    {
        // Simulando um retorno esperado do repositório
        $this->customerRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn(['customer1', 'customer2']);

        // Executando o método do controller
        $response = $this->controller->list();

        // Verificando se o retorno é uma resposta JSON válida
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['customer1', 'customer2']), $response->getContent());
    }

    public function test_create_returns_created_customer()
    {
        $request = new Request(['name' => 'John Doe']);

        $this->customerRepository
            ->shouldReceive('create')
            ->once()
            ->with($request->all())
            ->andReturn(['id' => 1, 'name' => 'John Doe']);

        $response = $this->controller->create($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['id' => 1, 'name' => 'John Doe']), $response->getContent());
    }

    public function test_show_returns_customer_data()
    {
        $this->customerRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn(['id' => 1, 'name' => 'John Doe']);

        $response = $this->controller->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['id' => 1, 'name' => 'John Doe']), $response->getContent());
    }

    public function test_update_updates_customer()
    {
        $request = new Request(['name' => 'John Updated']);

        $this->customerRepository
            ->shouldReceive('update')
            ->once()
            ->with(1, $request->all())
            ->andReturn(['id' => 1, 'name' => 'John Updated']);

        $response = $this->controller->update($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['id' => 1, 'name' => 'John Updated']), $response->getContent());
    }

    public function test_delete_removes_customer()
    {
        $this->customerRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $response = $this->controller->delete(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode(['deleted' => true]), $response->getContent());
    }

    public function test_attachRequest_adds_request_to_customer()
    {
        $request = new Request(['request_id' => 10]);

        $this->customerRepository
            ->shouldReceive('attach')
            ->once()
            ->with(1, [10])
            ->andReturn(true);

        $response = $this->controller->attachRequest($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode([true]), $response->getContent());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
