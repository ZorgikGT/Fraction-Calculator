<?php

namespace App\Controller;

use App\Calculator\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends AbstractController
{
    /**
     * @var Parser $parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Route("/healthcheck", name="healthCheck", methods={"GET"})
     */
    public function healthCheck(Request $request)
    {
        $contentType = $request->getContentType();
        if($contentType == "txt") {
            return new Response(
                'Content',
                Response::HTTP_OK,
                array('content-type' => 'text/plain')
            );
        }

        return new JsonResponse(["status" => "UP"], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/calc", name="calculate", methods={"POST"})
     */
    public function calculate(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        if(!is_array($data)) {
            return new JsonResponse(["message:" => "syntax error"], JsonResponse::HTTP_BAD_REQUEST);
        }
        if(!isset($data["equation"])) {
            return new JsonResponse(["message:" => "not exist"], JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->parser->main($data["equation"]);

        return new JsonResponse([ "equation" => $data["equation"], "result" => $result], JsonResponse::HTTP_OK);
    }
}
