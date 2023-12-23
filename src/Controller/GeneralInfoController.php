<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralInfoController extends AbstractController
{
    #[Route('/general_info/designkit', name: 'app_general_info_designkit')]
    public function index(): Response
    {
        return $this->render('general_info/designkit.html.twig', [
            'controller_name' => 'GeneralInfoController',
        ]);
    }
}
