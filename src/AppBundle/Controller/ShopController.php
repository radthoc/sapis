<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    private $resource;
    private $action;
    private $params;

    private $response_code = 200;

    private $response_codes = [
        'OK' => 200,
        'BAD-REQUEST' => 400,
        'NOT-FOUND' => 404,
    ];

    private $resourcesActionMapping = [
        'GET' => [
            'items' => [
                'list' => 'find'
            ]
        ],
        'POST' => [
            'items' => [
                'save' => 'persist'
            ]
        ],
        'PUT' => [
            'cart' => [
                'add' => 'persist'
            ]
        ]
    ];

    /**
     * @Route("/{resource}/{action}",
     * defaults={"resource" = null, "action" = null},
     * name="shop_root")
     * @param Request $request
     * @param null $resource
     * @param null $action
     * @return Response
     */
    public function indexAction(Request $request, $resource = null, $action = null)
    {
        $result = '';
        $contentType = 'text/plain';

        if (empty($resource) || empty($action)) {
            $result = 'Missing parameters';
            $this->response_code = $this->response_codes[ 'BAD-REQUEST' ];
        } else {
            $this->resource = $resource;
            $this->action = $action;

            $request = Request::createFromGlobals();

            $method = $request->getMethod();
            $this->params = $request->getContent();

            if ($request->headers->get('content_type') == 'application/json') {
                $this->params = json_decode($this->params, true);
            }

            if ($mappedAction = $this->resourcesActionMatch($method)) {
                $getResultsMethod = 'get' . ucfirst($method) . 'Results';

                try {
                    list($result, $contentType) = $this->$getResultsMethod($mappedAction);

                } catch (\Exception $e) {echo $e->getMessage();exit;
                    $result = $e->getMessage();
                    $contentType = 'text/plain';
                    $this->response_code = $e->getCode();
                }
            } else {
                $result = 'Method or action not implemented for the resource ' . $this->resource;
                $this->response_code = $this->response_codes['BAD-REQUEST'];
            }
        }

        $response = new Response(
            'Content',
            $this->response_code,
            ['content-type' => $contentType]
        );

        $response->setContent($result);
        $response->setStatusCode($this->response_code);
        $response->prepare($request);
        //$response->send();

        return $response;
    }

    private function resourcesActionMatch($method)
    {
        if (array_key_exists($this->resource, $this->resourcesActionMapping[$method])) {
            if (array_key_exists($this->action, $this->resourcesActionMapping[$method][$this->resource])) {
                return $this->resourcesActionMapping[$method][$this->resource][$this->action];
            }
        }

        return false;
    }

    private function getPutResults($action)
    {
        if (empty($this->params)) {
            throw new \Exception("Missing parameters", 400);
        }

        return $this->get($this->resource)->$action($this->params);
    }

    private function getPostResults($action)
    {
        if (empty($this->params)) {
            throw new \Exception("Missing parameters", 400);
        }

        return $this->get($this->resource)->$action($this->params);
    }

    private function getGetResults($action)
    {
        return $this->get($this->resource)->$action();
    }
}
