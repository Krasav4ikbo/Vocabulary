<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiBaseController extends AbstractController
{
    #[Route('/api', name: 'app_api_base')]
    public function index(): Response
    {
        return $this->render('api_base/index.html.twig', [
            'controller_name' => 'ApiBaseController',
        ]);
    }

}
