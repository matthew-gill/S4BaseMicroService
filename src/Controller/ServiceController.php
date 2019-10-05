<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="service_controller")
 */
class ServiceController
{
    /**
     * @Rest\Get("/")
     */
    public function homepageAction(): JsonResponse
    {
        $app_name = $_ENV['APP_NAME'];

        if (null === $app_name) {
            throw new NotFoundHttpException("No APP_NAME environment variable available");
        }

        return new JsonResponse(
            [
                "app_name" => $_ENV['APP_NAME'],
                "status"   => true,
            ]
        );
    }
}
