<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLinkController extends AbstractController
{
    private $em;
    private $repository;

    public function __construct(EntityManagerInterface $em, LinkRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin" , name="admin_index")
     */
    public function index(LinkRepository $repository): Response
    {
        $link = $repository->findAll();

        return $this->render('admin/index.html.twig', [
            'links' => $link
        ]);
    }

    /**
     * @Route("/admin/create" , name="admin_create")
     */
    public function create(Request $request)
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($link);
            $this->em->flush();
            $this->addFlash('success', "Le lien a bien été enregistré");
            return $this->redirectToRoute('admin_index', [], 301);
        }

        return $this->render('admin/create.html.twig', [
            'formLink' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit{id}" , name="admin_edit")
     */
    public function edit(Request $request, int $id)
    {
        $link = $this->repository->find($id);
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "Le lien a bien été modifié");
            return $this->redirectToRoute('admin_index', [], 301);
        }

        return $this->render('admin/edit.html.twig', [
            'formLink' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete{id}" , name="admin_delete")
     */
    public function delete(Request $request, int $id)
    {
        $link = $this->repository->find($id);

        $this->em->remove($link);
        $this->em->flush();
        $this->addFlash('success', "Le lien a bien été supprimé");
        return $this->redirectToRoute('admin_index', [], 301);
    }
}
