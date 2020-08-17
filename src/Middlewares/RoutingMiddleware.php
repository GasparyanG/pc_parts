<?php

namespace App\Middlewares;

use App\Services\TemplateEngine\Twig\Twig;
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
		    $r->addRoute(Request::METHOD_GET, "/cpu", ["Cpu", "getCollection"]);

		    // GPU
		    $r->addRoute(Request::METHOD_GET, "/gpu/{id}", ["Gpu", "get"]);
		    $r->addRoute(Request::METHOD_GET, "/gpu", ["Gpu", "getCollection"]);

		    // PSU
		    $r->addRoute(Request::METHOD_GET, "/psu/{id}", ["Psu", "get"]);
		    $r->addRoute(Request::METHOD_GET, "/psu", ["Psu", "getCollection"]);

            // STORAGE
            $r->addRoute(Request::METHOD_GET, "/storage/{id}", ["Storage", "get"]);
            $r->addRoute(Request::METHOD_GET, "/storage", ["Storage", "getCollection"]);

            // MEMORY
            $r->addRoute(Request::METHOD_GET, "/memory/{id}", ["Memory", "get"]);
            $r->addRoute(Request::METHOD_GET, "/memory", ["Memory", "getCollection"]);

            // MOTHERBOARD
            $r->addRoute(Request::METHOD_GET, "/motherboard/{id}", ["Mobo", "get"]);
            $r->addRoute(Request::METHOD_GET, "/motherboard", ["Mobo", "getCollection"]);

            // PcCASE
            $r->addRoute(Request::METHOD_GET, "/pc_case/{id}", ["PcCase", "get"]);
            $r->addRoute(Request::METHOD_GET, "/pc_case", ["PcCase", "getCollection"]);

            // COOLER
            $r->addRoute(Request::METHOD_GET, "/cooler/{id}", ["Cooler", "get"]);
            $r->addRoute(Request::METHOD_GET, "/cooler", ["Cooler", "getCollection"]);

            // HOME
            $r->addRoute(Request::METHOD_GET, "/home", ["HOME", "get"]);

            // Redux Test
            $r->addRoute(Request::METHOD_GET, "/redux", ["Redux", "get"]);
        });

		$httpMethod = $request->getMethod();
		$uri = $request->getBaseUrl().$request->getPathInfo();
		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

		switch ($routeInfo[0]) {
		    case FastRoute\Dispatcher::NOT_FOUND:
		        return Response::create((new Twig())->render("not_found_page.html.twig", ["not_home" => true]));
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
