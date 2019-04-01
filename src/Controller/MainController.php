<?php

namespace App\Controller;

use App\Calculator\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function healthCheck()
    {
        return new JsonResponse(["status" => "UP"], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/calc", name="calculate", methods={"POST"})
     */
    public function calculate(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        $result = $this->parser->main($data["equation"]);

        return new JsonResponse([ "equation" => $data["equation"], "result" => $result], JsonResponse::HTTP_OK);
    }
}
