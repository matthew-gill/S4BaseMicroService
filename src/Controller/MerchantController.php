<?php

namespace App\Controller;

use App\Entity\Merchant;
use App\Form\MerchantType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Merchant controller.
 *
 * @Route("/api", name="api_")
 */
class MerchantController extends AbstractFOSRestController
{
    /**
     * Lists all Merchants.
     *
     * @Rest\Get("/merchants")
     *
     * @return Response
     */
    public function getMerchantAction(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Merchant::class);
        $movies = $repository->findall();

        return $this->handleView($this->view($movies));
    }

    /**
     * Create Merchant.
     *
     * @Rest\Post("/merchant")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postMerchantAction(Request $request): Response
    {
        $merchant = new Merchant();
        $form = $this->createForm(MerchantType::class, $merchant);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($merchant);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors()));
    }
}
