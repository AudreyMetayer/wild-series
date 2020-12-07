<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{

    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/program/{programId}", methods={"GET"}, name="show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     */
    public function show(Program $program): Response
    {

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $program]);

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            ]);

    }
    /**
     * @Route("/{programId}/seasons/{seasonId}", methods={"GET"}, name="season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     */

    public function showSeason(Program $program, Season $season): Response
    {

    $episodes = $this->getDoctrine()
        ->getRepository(Episode::class)
        ->findBy(['season' => $season]);


    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episodes' => $episodes,
    ]);
    }

    /**
     * @Route("/{programId}/seasons/{seasonId}/episodes/{episodeId}", methods={"GET"}, name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {

       return $this->render('program/episode_show.html.twig', [
           'program' => $program,
           'season' => $season,
           'episode' => $episode,
       ]);
    }
}
