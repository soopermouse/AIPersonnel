<?php

namespace App\Controller;

use App\Entity\Integration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IntegrationController extends AbstractController
{
    #[Route('/integrations', name: 'app_integrations')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('integrations/index.html.twig', [
            'integrations' => $em->getRepository(Integration::class)->findAll(),
        ]);
    }

    #[Route('/integrations/create', name: 'app_integrations_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $integration = new Integration();
        $integration->provider = (string) $request->request->get('provider');
        $integration->type = (string) $request->request->get('type');
        $integration->enabled = $request->request->getBoolean('enabled');
        $integration->config = [
            'base_url' => $request->request->get('baseUrl'),
            'notes' => $request->request->get('notes'),
        ];

        $em->persist($integration);
        $em->flush();

        $this->addFlash('success', 'Integration saved.');
        return $this->redirectToRoute('app_integrations');
    }
}