<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    private $resource = 'cart';
    private $response_code = Response::HTTP_OK;

    /**
     * @Route("/cart/add", name="cart_add")
     * @param Request $request
     * @return Response
     */
    public function cartAddAction(Request $request)
    {
        $result = '';
        $contentType = 'text/plain';

        $request = Request::createFromGlobals();

        $method = $request->getMethod();
      
        if ($method == 'PUT')
        {
            $params = $request->getContent();

            if ($request->headers->get('content_type') == 'application/json') {
                $params = json_decode($params, true);
            }

            try {
                $result = $this->get($this->resource)->persist($params);
            } catch (\Exception $e) {
                $result = $e->getMessage();
                $contentType = 'text/plain';
                $this->response_code = $e->getCode();
            }
        }
        else
        {
            $result = 'Method or action not implemented for the resource ' . $this->resource;
            $this->response_code = Response::HTTP_BAD_REQUEST;
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
}
