<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use App\Repository\LinkRepository;

class TreeController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(LinkRepository $linkRepository)
    {
        $link = new Link();

        $link = $linkRepository->findAll();

        return $this->render('tree/home.html.twig', [
            'title' => "Lewys Tree",
            'links' => $link
        ]);
    }
}
