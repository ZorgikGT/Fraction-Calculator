<?php

namespace App\Controller;

use App\Calculator\Parser;
use App\Generators\RandomNumberGenerator;
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
     * @var RandomNumberGenerator $rng
     */
    private $rng;

    public function __construct(Parser $parser, RandomNumberGenerator $rng)
    {
        $this->parser = $parser;
        $this->rng = $rng;
    }

    /**
     * @Route("/healthcheck", name="healthCheck", methods={"GET"})
     */
    public function healthCheck(Request $request)
    {
        $contentType = $request->getContentType();
        if($contentType == "txt") {
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

    /**
     * @Route("/montyhall", name="montyHall", methods={"GET"})
     */
    public function montyHall()
    {
        try{
            $numbers = $this->rng->getArrayOfNumbers();
        }catch (\Exception $exception)
        {
            return new JsonResponse(["Exception" => $exception->getMessage()], $exception->getCode());
        }

        $change = 0;
        $noChange = 0;
        $doors = array("true", "false", "false");

        for($i = 0; $i < sizeof($numbers); $i++) {
            $choice = $doors[$numbers[$i]];
            if ($choice == 'false') {
                $change++;
            } else {
                $noChange++;
            }
        }

        $percentChange = ($change / ($change + $noChange)) * 100 . "%";
        $percentNoChange = ($noChange / ($change + $noChange)) * 100 . "%";

        return new JsonResponse(
            ["Общее кол-во попыток" => $change + $noChange,
            "Если вы измените свое решение" => $change,
            "Изменил" => $percentChange,
            "Если вы не измените свое решение" => $noChange,
            "Не изменил" => $percentNoChange],
            JsonResponse::HTTP_OK
        );
    }
}
