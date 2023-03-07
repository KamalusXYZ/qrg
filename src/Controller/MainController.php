<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    #[IsGranted("ROLE_USER")]
    public function index(Request $request): Response
    {
        $pixelRate = 0;
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'pixelRate' => $pixelRate
        ]);
    }

    #[Route('/upload', name: 'app_upload')]
    public function upload(QuestionRepository $questionRepository): Response
    {
        $pixelRate = 0;
        $uploadPath = "C:\wamp64\www\qrg\public\uploads\images\\";
        $question = $questionRepository->find('1')->setAttachmentPath("image.png");
        $extension = explode('/',  $_FILES['fileUpload']['type']);


        if (trim($_FILES["fileUpload"]["tmp_name"]) != "" and $_FILES["fileUpload"]["type"] == "images/png") {

            move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $uploadPath . basename("image.".$extension[1]));
            $im = imagecreatefrompng("C:\wamp64\www\qrg\public\uploads\images\image.".$extension[1]);
            imagefilter($im,   IMG_FILTER_PIXELATE, $pixelRate );
            imagepng($im,"C:\wamp64\www\qrg\public\uploads\images\image2.png" );
            $questionRepository->save($question, true);

        }
        return $this->render('main/index.html.twig', [
            'pixelRate' => $pixelRate
        ]);

    }

    #[Route('/modify', name: 'app_modify')]
    public function modify(Request $request): Response
    {
        $pixelRate = $request->get('pixel');

        $im = imagecreatefrompng("C:\wamp64\www\qrg\public\uploads\images\image.png");
        imagefilter($im,   IMG_FILTER_PIXELATE, $pixelRate );
        imagepng($im,"C:\wamp64\www\qrg\public\uploads\images\image2.png" );
        return $this->render('main/index.html.twig', [
            'pixelRate' => $pixelRate
        ]);
    }
//
//    #[Route('/modify2', name: 'app_modify2')]
//    public function modify2(): Response
//    {
//        $im = imagecreatefrompng("C:\wamp64\www\qrg\public\uploads\images\image.png");
//        imageresolution($im, 72);
//        imagepng($im,"C:\wamp64\www\qrg\public\uploads\images\image.png" );
//        return $this->render('main/index.html.twig', [
////            'images' => $images
//        ]);
//    }
}
