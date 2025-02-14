<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Http\Controllers\RequestController;
use App\Repositories\RequestRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RequestControllerTest extends TestCase
{
    protected $requestRepository;
    protected $customerRepository;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestRepository = Mockery::mock(RequestRepository::class);
        $this->customerRepository = Mockery::mock(CustomerRepository::class);

        $this->controller = new RequestController($this->requestRepository, $this->customerRepository);
    }

    public function testList()
    {
        $this->requestRepository->shouldReceive('all')->once()->andReturn([]);

        $response = $this->controller->list();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([], $response->getData(true));
    }

    public function testCreate()
    {
        $requestData = ['customer_id' => 1, 'products' => [1, 2, 3]];
        $mockRequest = Request::create('/create', 'POST', $requestData);

        $this->requestRepository->shouldReceive('create')->once()->andReturn((object) ['id' => 1, 'customer_id' => 1]);
        $this->requestRepository->shouldReceive('attach')->once()->andReturn(true);

        $response = $this->controller->create($mockRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function testShow()
    {
        $this->requestRepository->shouldReceive('find')->with(1)->once()->andReturn(['id' => 1]);

        $response = $this->controller->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['id' => 1], $response->getData(true));
    }

    public function testUpdate()
    {
        $requestData = ['status' => 'approved'];
        $mockRequest = Request::create('/update/1', 'PUT', $requestData);

        $this->requestRepository->shouldReceive('update')->with(1, $requestData)->once()->andReturn(['id' => 1, 'status' => 'approved']);

        $response = $this->controller->update($mockRequest, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['id' => 1, 'status' => 'approved'], $response->getData(true));
    }

    public function testDelete()
    {
        $this->requestRepository->shouldReceive('delete')->with(1)->once()->andReturn(true);

        $response = $this->controller->delete(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['deleted' => true], $response->getData(true));
    }
}
