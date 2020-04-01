<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/actor", name="actor")
     */
    public function index()
    {
        return $this->render('actor/index.html.twig', [
            'controller_name' => 'ActorController',
        ]);
    }

    /**
     * @Route("/actor/{id}", name="show_actor")
     */
    public function showActor(Actor $actor)
    {
        $programs = $actor->getPrograms();

        return $this->render('actor/actor.html.twig', [
            'actor' => $actor,
            'programs' => $programs,
        ]);
    }
}
