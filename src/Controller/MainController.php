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

    /**
     * MainController constructor.
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Route("/healthcheck", name="healthCheck", methods={"GET"})
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function healthCheck(Request $request)
    {
        $contentType = $request->getContentType();
        if ($contentType == "txt") {

            return new Response(
                "status: \tUP",
                Response::HTTP_OK,
                array('content-type' => 'text/plain')
            );
        }

        return new JsonResponse(["status" => "UP"], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/calc", name="calculate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function calculate(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        if (!is_array($data)) {

            return new JsonResponse([
                "equation" => $data["equation"],
                "error:" => "Bad Request"
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        if (!isset($data["equation"])) {

            return new JsonResponse([
                "equation" => $data["equation"],
                "error:" => "Bad Request"
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $result = $this->parser->main($data["equation"]);
        } catch (\Exception $e) {

            return new JsonResponse([
                "equation" => $data["equation"],
                "error:" => "Bad Request"
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([ "equation" => $data["equation"], "result" => $result], JsonResponse::HTTP_OK);
    }
}
