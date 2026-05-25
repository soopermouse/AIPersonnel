<?php

namespace App\Controller;

use App\Entity\ModuleDefinition;
use App\Entity\ModuleJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('home/index.html.twig', [
            'modules' => $em->getRepository(ModuleDefinition::class)->findAll(),
            'jobs' => $em->getRepository(ModuleJob::class)->findBy([], ['createdAt' => 'DESC'], 10),
        ]);
    }
}