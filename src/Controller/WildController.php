<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException("No program found in program's table .");
        }

        return $this->render("wild/index.html.twig", [
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="wild_show")
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this->createNotFoundException("No slug has been sent to find a program in program's table.");
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                "No program with '.$slug.' title, found in program's table."
            );
        }

        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
            'program' => $program,
        ]);
    }

    /**
     * @Route("/category/{categoryName}", name="show_category")
     */
    public function showByCategory(string $categoryName): Response
    {

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => mb_strtolower($categoryName)]);

        if (!$category) {
            throw $this->createNotFoundException(
                "No program with '$categoryName' category, found in program's table."
            );
        }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ['category' => $category],
                ['id' => 'DESC'],
                3
            );

        return $this->render('wild/category.html.twig', [
            'programs' => $programs,
        ]);

    }

    /**
     * @Route("/show/program/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show_program")
     */
    public function showByProgram(?string $slug): Response
    {
        if (!$slug) {
            throw $this->createNotFoundException("No slug has been sent to find a program in program's table.");
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(
                ['title' => mb_strtolower($slug)]
            );
        if (!$program) {
            throw $this->createNotFoundException(
                "No program with '$slug' title, found in program's table."
            );
        }

        $seasons = $program->getSeasons();

        return $this->render('wild/program.html.twig', [
            'slug' => $slug,
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    /**
     * @Route("/show/season/{id<^[0-9]+$>}", defaults={"id" = null}, name="show_season")
     */
    public function showBySeason(int $id): Response
    {
        if (!$id) {
            throw $this->createNotFoundException("no season found with this id");
        }
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find(['id' => $id]);

        $program = $season->getProgram();

        $episodes = $season->getEpisodes();

        return $this->render('wild/season.html.twig', [
            'season' => $season,
            'program' => $program,
            'episodes' => $episodes
        ]);
    }

    /**
     * @Route("/episode/{id}", name="show_episode")
     */
    public function showEpisode(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();

        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'program' => $program,
            'season' => $season,
        ]);
    }
}