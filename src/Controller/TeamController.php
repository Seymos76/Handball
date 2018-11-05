<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route(path="/les-equipes", name="teams")
     * @param TeamRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teams(TeamRepository $repository)
    {
        return $this->render(
            'team/teams.html.twig', [
                'teams' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route(path="/equipe/{slug}", name="team")
     * @param TeamRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function team(TeamRepository $repository, string $slug)
    {
        return $this->render(
            'team/team.html.twig', [
                'team' => $repository->findOneBy(
                    array(
                        'slug' => $slug
                    )
                )
            ]
        );
    }
}
