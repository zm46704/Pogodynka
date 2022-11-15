<?php

namespace App\Controller;

use App\Entity\Data;
use App\Form\DataType;
use App\Repository\DataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/data')]
class DataController extends AbstractController
{
    #[Route('/', name: 'app_data_index', methods: ['GET'])]
    public function index(DataRepository $dataRepository): Response
    {
        return $this->render('data/index.html.twig', [
            'data' => $dataRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_data_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_DATA_NEW')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = new Data();
        $form = $this->createForm(DataType::class, $data, ['validation_groups' => [ 'edit','new']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('data/new.html.twig', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_data_show', methods: ['GET'])]
    #[IsGranted('ROLE_DATA_SHOW')]
    public function show(Data $data): Response
    {
        return $this->render('data/show.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_data_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_DATA_EDIT')]
    public function edit(Request $request, Data $data, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DataType::class, $data, ['validation_groups' => [ 'edit','new']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('data/edit.html.twig', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_data_delete', methods: ['POST'])]
    #[IsGranted('ROLE_DATA_DELETE')]
    public function delete(Request $request, Data $data, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$data->getId(), $request->request->get('_token'))) {
            $entityManager->remove($data);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_data_index', [], Response::HTTP_SEE_OTHER);
    }
}
