<?php

namespace App\Controller;

use App\Service\POEStashHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @var POEStashHelper
     */
    private $POEStashHelper;

    public function __construct(POEStashHelper $POEStashHelper)
    {
        $this->POEStashHelper = $POEStashHelper;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {

        return $this->render('homepage.twig', $this->POEStashHelper->findHighValueItems());
    }
}
