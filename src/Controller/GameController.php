<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\MeetingRepository;
use App\Service\Blog\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route(path="/matchs/{page}", name="games", requirements={"page"="\d+"})
     * @param GameRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function games(GameRepository $repository, int $page = 1, Pagination $pagination)
    {
        $perPage = 1;
        $allGames = $repository->findAll();
        $nbPages = $pagination->getTotalPages($allGames, $perPage);
        $limit = $pagination->getLimit($page, $perPage);
        $offset = $pagination->getOffset($limit, $perPage);
        $games = $repository->findBy(
            [],
            ['id' => 'DESC'],
            $limit,
            $offset
        );
        return $this->render(
            'game/games.html.twig', [
                'games' => $games,
                'per_page' => $perPage,
                'nb_pages' => $nbPages,
                'page' => $page
            ]
        );
    }

    /**
     * @Route(path="/resultats/{page}", name="results", requirements={"page"="\d+"})
     * @param GameRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function results(MeetingRepository $repository, int $page = 1, Pagination $pagination)
    {
        $perPage = 1;
        $allResults = $repository->findAll();
        $nbPages = $pagination->getTotalPages($allResults, $perPage);
        $limit = $pagination->getLimit($page, $perPage);
        $offset = $pagination->getOffset($limit, $perPage);
        $meetings = $repository->findBy(
            [],
            ['id' => 'DESC'],
            $limit,
            $offset
        );
        return $this->render(
            'game/results.html.twig', [
                'meetings' => $meetings,
                'per_page' => $perPage,
                'nb_pages' => $nbPages,
                'page' => $page
            ]
        );
    }
}
