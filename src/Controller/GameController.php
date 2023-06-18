<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/game')]
class GameController extends AbstractController
{
    #[Route('/', name: 'app_game_index', methods: ['GET'])]
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_game_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GameRepository $gameRepository): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->save($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/new.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }
    
    #[Route('/load', name: 'app_game_load', methods: ['GET', 'POST'])]
    public function load(Request $request, GameRepository $gameRepository,QuestionRepository $questionRepository, UserInterface $user): Response
    {
        $game = new Game($user);
        $game->setUser($user);
        $game->setCreateDateTime(date_create('now'));
        $questions = $questionRepository->findRandomQuestion(10, $user->getId());
        foreach($questions as $question){
            $game->addQuestion($question);
            // dd($game);
            
        }
        $gameRepository->save($game, true);

        $count = 1;

        return $this->redirectToRoute('app_game_play', ['id' => $game->getId(), 'count' => $count], Response::HTTP_SEE_OTHER);
    }

    #[Route('/play/{id}/turn{count}', name: 'app_game_play', methods: ['GET', 'POST'])]
    public function play(Request $request, GameRepository $gameRepository, UserInterface $user, $id, $count): Response
    {
            $count += 1;
            $game = $gameRepository->find($id);
            $step = $game->getQuestions();
                
            return $this->renderForm('game/new.html.twig', [
                'game' => $game,
                'question'=> $step[$count-2],
                'count' =>$count,
            ]);
        
    }

    #[Route('/play/{id}/turn{count}', name: 'app_game_next_turn', methods: ['GET', 'POST'])]
    public function nextTurn(Request $request, GameRepository $gameRepository, UserInterface $user, $id, $count): Response
    {

        $game = $gameRepository->find($id);
        return $this->redirectToRoute('app_game_play', ['id' => $game->getId(), 'count' => $count], Response::HTTP_SEE_OTHER);

    }



    #[Route('/{id}', name: 'app_game_show', methods: ['GET'])]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_game_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->save($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/edit.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_game_delete', methods: ['POST'])]
    public function delete(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $gameRepository->remove($game, true);
        }

        return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
