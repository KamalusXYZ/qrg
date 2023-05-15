<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/settings')]
#[IsGranted("ROLE_PUBLISHER")]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(Request $request): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',            
        ]);

    }
    
    #[Route('/validating/{id}', name: 'app_validate_question')]
    public function validateQuestion(Request $request, QuestionRepository $questionRepository, $id): Response
    {
        $question = $questionRepository->find($id);
        $question->setValid(true);
        $question->setChecked(true);
        $questionRepository->save($question, true);

        return $this->render('question/show.html.twig', [
            'controller_name' => 'AdminController',
            'id'=> $id,
            'question'=> $question,

        ]);
    }

    #[Route('/refuse/{id}', name: 'app_refuse_question')]
    public function refuseQuestion(Request $request, QuestionRepository $questionRepository, $id): Response
    {
        $question = $questionRepository->find($id);
        $question->setDenied(true);
        $question->setValid(false);
        $question->setChecked(true);
        $questionRepository->save($question, true);

        return $this->render('question/show.html.twig', [
            'controller_name' => 'AdminController',
            'id'=> $id,
            'question'=> $question,
        ]                 
        );
    }

}
