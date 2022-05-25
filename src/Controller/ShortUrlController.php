<?php

namespace App\Controller;

use App\Service\RedirectService;
use App\Validator\ShortUrlValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ShortUrlController extends AbstractController
{

    /**
     * @Route("/{shortUrl}", name="app_redirect_to_link", methods="GET")
     * @param string $shortUrl
     * @param ShortUrlValidator $shortUrlValidator
     * @param RedirectService $redirectService
     * @return Response
     * @throws Exception
     */
    public function redirectToLink(
        string $shortUrl,
        ShortUrlValidator $shortUrlValidator,
        RedirectService $redirectService
    ): Response {
        $params = [
            'shortUrl' => $shortUrl
        ];

        $violations = $shortUrlValidator->validation($params);

        if ($violations->count()) {
            throw new BadRequestHttpException($violations);
        }

        return $this->redirect($redirectService->getOriginUrl($params));
    }

}
