<?php

namespace App\Controller;

use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrganizationController extends AbstractController
{
    #[Route('/organization', name: 'app_organization')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('organization/index.html.twig', [
            'organizations' => $em->getRepository(Organization::class)->findAll(),
        ]);
    }

    #[Route('/organization/create', name: 'app_organization_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $org = new Organization();
        $org->name = (string) $request->request->get('name');
        $org->countryCode = (string) $request->request->get('countryCode', 'NL');
        $org->currency = (string) $request->request->get('currency', 'EUR');
        $org->settings = [
            'timezone' => $request->request->get('timezone', 'Europe/Amsterdam'),
        ];

        $em->persist($org);
        $em->flush();

        $this->addFlash('success', 'Organization created.');
        return $this->redirectToRoute('app_organization');
    }
}