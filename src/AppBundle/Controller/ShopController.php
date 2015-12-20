<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\ItemsRepository as items;
use AppBundle\Repository\CartRepository as cart;

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
    
    /**
     * @Route("/{resource}/{action}",
     * defaults={"resource" = null, "action" = null},
     * name="shop_root")
     */
    public function indexAction(Request $request, $resource = null, $action = null)
    {
	$result = '';
	
	if (empty($resource) || empty($action))
	{
	    $result = 'Missing parameters';
	    $contenType = 'text/plain';
	    $this->response_code = $this->response_codes['BAD-REQUEST'];
	}
        else
	{
	    $this->resource = $resource;
	    $this->action = $action;
	    
	    $request = Request::createFromGlobals();
	
	    $method = $request->getMethod();
	    $this->params = $request->getContent();
	    
	    if ($request->headers->get('content_type') == 'json')
	    {
		$this->params = json_decode($this->params, true);
	    }
	    
	    $getResultsMethod = 'get' . ucfirst($method) . 'Results';
	    
	    if (method_exists($this, $getResultsMethod))
	    {
		try{
		    list($result, $contentType) =  $this->$getResultsMethod();
		}
		catch(\Exception $e)
		{
		    $result = $e->getMessage();
		    $contenType = 'text/plain';
		    $this->response_code = $e->getCode();
		}
	    }
	    else
	    {
		$result = 'Method not implemented';
		$contenType = 'text/plain';
		$this->response_code = $this->response_codes['BAD-REQUEST'];
	    }
	}
        
	$response = new Response(
            'Content',
            $this->response_code,
            array('content-type' => $contentType)
        );
	
	$response->setContent($result);
        $response->setStatusCode($this->response_code);
        $response->prepare($request);
        $response->send();

        return $response;
    }
    
    private function getPutResults()
    {
        return $this->get($this->resource)->$this->action($this->params);
    }
    
    private function getPostResults()
    {
        return $this->get($this->resource)->$this->action($this->params);
    }    
    
    private function getGetResults()
    {
        return $this->get($this->resource)->$this->action();
    }
}

