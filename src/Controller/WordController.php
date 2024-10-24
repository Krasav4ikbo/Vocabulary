<?php
namespace App\Controller;

use App\Entity\Word;
use App\Form\Word\WordsCompareForm;
use App\Repository\WordRepository;
use App\Services\WordCompareService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WordController extends AbstractController
{
    #[Route('/word-success', name: 'app_word_success', methods: ['GET'])]
    public function success(): Response
    {
        return $this->render('word/success.html.twig');
    }

    #[Route('/word-check', name: 'app_word_check', methods: ['GET', 'POST'])]
    public function check(Request $request, WordCompareService $wordCompareService): Response
    {
        $word = $wordCompareService->getWordForTraining();

        $form = $this->createForm(WordsCompareForm::class, $word);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getData();

            if($wordCompareService->checkWordTranslation($word->getUuid(), $word->getTranslation())) {
                $wordCompareService->markTranslationAsSuccess($word->getUuid());

                return $this->redirectToRoute('app_word_success');
            } else {
                $wordCompareService->markTranslationAsFailed($word->getUuid());

                $form->addError(new FormError('Translation is wrong. Try one more time'));
            }
        }

        return $this->render('word/check.html.twig', [
            'form' => $form,
            'word' => $wordCompareService->getWordTranslationByLanguage($word, 'sv')
        ]);
    }
}