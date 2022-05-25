<?php

namespace App\Controller;

use App\Service\MinificationService;
use App\Validator\MinificationValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MinificationController extends AbstractController
{
    /**
     * @Route("/minification/", name="app_minification_url", methods="POST")
     * @param Request $request
     * @param MinificationValidator $minificationValidator
     * @param MinificationService $minificationService
     * @return Response
     * @throws Exception
     */
    public function minification(
        Request                 $request,
        MinificationValidator   $minificationValidator,
        MinificationService     $minificationService
    ): Response {

        $params = [
            'url'        => $request->get('url'),
            'expired'    => $request->get('expired')
        ];

        $violations = $minificationValidator->validation($params);

        if ($violations->count()) {
            throw new BadRequestHttpException($violations);
        }

        return $this->json(
            [
                'status'    => 'OK',
                'short url' => $minificationService->process($params)
            ]
        );
    }

}
