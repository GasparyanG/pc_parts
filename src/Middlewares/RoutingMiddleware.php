<?php

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Dispatching\DispatcherHelper\RoutingInformationHandler;
use App\Services\Dispatching\Dispatcher;
use FastRoute;

class RoutingMiddleware implements MiddlewareInterface
{
	/**
	 * @var MiddlewareInterface|null
	 */
	private $next = null;

	public function process(Request $request): Response
	{
		$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
		    // CPU
		    $r->addRoute(Request::METHOD_GET, "/cpu/{id}", ["Cpu", "get"]);

		    // GPU
		    $r->addRoute(Request::METHOD_GET, "/gpu/{id}", ["Gpu", "get"]);

		    // PSU
		    $r->addRoute(Request::METHOD_GET, "/psu/{id}", ["Psu", "get"]);

            // STORAGE
            $r->addRoute(Request::METHOD_GET, "/storage/{id}", ["Storage", "get"]);

            // MEMORY
            $r->addRoute(Request::METHOD_GET, "/memory/{id}", ["Memory", "get"]);

            // MOTHERBOARD
            $r->addRoute(Request::METHOD_GET, "/motherboard/{id}", ["Mobo", "get"]);

            // PcCASE
            $r->addRoute(Request::METHOD_GET, "/pc_case/{id}", ["PcCase", "get"]);
		});

		$httpMethod = $request->getMethod();
		$uri = $request->getBaseUrl().$request->getPathInfo();
		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

		switch ($routeInfo[0]) {
		    case FastRoute\Dispatcher::NOT_FOUND:
		        // ... 404 Not Found
		        break;
		    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		        $allowedMethods = $routeInfo[1];
		        // ... 405 Method Not Allowed
		        break;
		    case FastRoute\Dispatcher::FOUND:
				// dispatcher hadnling preparation						        
		        $handler = $routeInfo[1];
		        $placeholders = $routeInfo[2];
		        $routingInformationHandler = new RoutingInformationHandler($handler, $placeholders);
		        
		        $dispatcher = new Dispatcher();
		        return $dispatcher->dispatch($request, $routingInformationHandler);
		        break;
		}
	}

	public function setNext(MiddlewareInterface $middelware): void
	{
		$this->next = $middelware;
	}
}
