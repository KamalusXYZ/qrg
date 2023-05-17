<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\Mapping\Id;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Void_;
use SebastianBergmann\Type\NullType;
use SebastianBergmann\Type\VoidType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/question')]
#[IsGranted("ROLE_PUBLISHER")]
class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    #[Route('/myquestions', name: 'app_question_my_questions', methods: ['GET'])]
    public function myQuestions(QuestionRepository $questionRepository, UserInterface $user): Response
    {
        return $this->render('question/my_questions.html.twig', [
            'questions' => $questionRepository->findMyQuestions($user),
        ]);
    }


    #[Route('/tovalid', name: 'app_question_to_valid', methods: ['GET'])]
    public function toValid(QuestionRepository $questionRepository): Response
    {
        return $this->render('question/index.html.twig', [
            'questions' => $questionRepository->findToValidQuestion(),
        ]);
    }

    #[Route('/addtag/{id}/tag_{tag}/{pixelRate}', name: 'app_question_add_tag', methods: ['GET'])]
    public function addTag(QuestionRepository $questionRepository, $id, $tag, TagRepository $tagRepository, $pixelRate): Response
    {
        $question = $questionRepository->find($id);
        $tags = $tagRepository->findAll($question->getId());
        $question->addTag($tagRepository->find($tag));
        $questionRepository->save($question, true);

        return $this->render('question/pixelize_and_preview.html.twig', [
            'question' => $question,
            'pixelRate' => $pixelRate,
            'tags'=> $tags,
        ]);
                
    }

    #[Route('/removetag/{id}/tag_{tag}/{pixelRate}', name: 'app_question_remove_tag', methods: ['GET'])]
    public function removeTag(QuestionRepository $questionRepository, $id, $tag, TagRepository $tagRepository, $pixelRate): Response
    {
        $question = $questionRepository->find($id);
        $tags = $tagRepository->findAll($question->getId());
        $question->removeTag($tagRepository->find($tag));
        $questionRepository->save($question, true);

        return $this->render('question/pixelize_and_preview.html.twig', [
            'question' => $question,
            'pixelRate' => $pixelRate,
            'tags'=> $tags,
        ]);
                
    }

    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionRepository $questionRepository, SluggerInterface $slugger, UserInterface $users, TagRepository $tagRepository): Response
    {
        $question = new Question();
        $question->addUser($users);
        $question->setCreateDateTime(date_create('now'));
        $question->setValid(false);
        $question->setChecked(false);
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form->get('attachmentPath')->getData();
        
        // this condition is needed because the 'attachmentPath' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($uploadedFile) {
        $newFilename = "image-".uniqid().'.'.$uploadedFile->guessExtension();

    // Move the file to the directory where attachmentPaths are stored
        try {
        $uploadedFile->move(
            $this->getParameter('images_directory'),
            $newFilename
        );
            } catch (FileException $e) {
                dd($e);
            }

    $question->setAttachmentPath($newFilename);

    copy($this->getParameter('images_directory').$question->getAttachmentPath() , $this->getParameter('images_modified_directory').$question->getAttachmentPath());
    }

            $questionRepository->save($question, true);



            return $this->redirectToRoute('app_question_pixelize_and_preview', [ 
                'id' => $question->getId(),
                
                 ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/new.html.twig', [
            'question' => $question,
            'form' => $form,
            
        ]);
    }

    #[Route('/{id}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/preview/{id}', name: 'app_question_pixelize_and_preview', methods: ['GET'])]
    public function pixelizeAndPreview(Question $question, TagRepository $tagRepository): Response
    {   
        $tags = $tagRepository->findAll($question->getId());
        $pixelRate = 0;
        return $this->render('question/pixelize_and_preview.html.twig', [
            'question' => $question,
            'pixelRate' => $pixelRate,
            'tags'=> $tags,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form->get('attachmentPath')->getData();

        // this condition is needed because the 'attachmentPath' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($uploadedFile) {
        $newFilename = "image-".uniqid().'.'.$uploadedFile->guessExtension();

    // Move the file to the directory where attachmentPaths are stored
        try {
        $uploadedFile->move(
            $this->getParameter('images_directory'),
            $newFilename
        );
            } catch (FileException $e) {
        // ... handle exception if something happens during file upload
    }

    $question->setAttachmentPath($newFilename);
    }

            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);


        
    }

    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pixelize/{id}', name: 'app_apply_pixelisation')]
    public function applyPixelisation(Request $request, $id, QuestionRepository $questionRepository, TagRepository $tagRepository): Response
    {
        $pixelRate = $request->get('pixel');
        $question = $questionRepository->find($id);
        $tags = $tagRepository->findAll($question->getId());

        if(str_ends_with($question->getAttachmentPath(), 'png')){
            $im = imagecreatefrompng($this->getParameter('images_directory') . $question->getAttachmentPath());

        }elseif(str_ends_with($question->getAttachmentPath(), 'jpg') || str_ends_with($question->getAttachmentPath(), 'jpeg')){
            $im = imagecreatefromjpeg($this->getParameter('images_directory') . $question->getAttachmentPath());
        }

        $imMod = $im;
        
        imagefilter($imMod, IMG_FILTER_PIXELATE, $pixelRate);
        imagepng($imMod,$this->getParameter('images_modified_directory') . $question->getAttachmentPath());

        $im = $imMod;

        $question->setPixelationRate($pixelRate);
        $questionRepository->save($question, true);

        return $this->render('question/pixelize_and_preview.html.twig', [
            'pixelRate' => $pixelRate,
            'question' => $question,
            'tags'=> $tags,
        ]);
    }
}