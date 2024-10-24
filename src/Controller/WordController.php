<?php

namespace App\Controller;

use App\Entity\Word;
use App\Factory\Form\WordsCompareFormFactory;
use App\Services\WordCompareService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class WordController extends AbstractController
{
    #[Route('/word-success', name: 'app_word_success', methods: ['GET'])]
    public function success(): Response
    {
        return $this->render('word/success.html.twig');
    }

    #[Route('/word', name: 'app_word', methods: ['GET'])]
    public function index(WordCompareService $wordCompareService, WordsCompareFormFactory $factory): Response
    {
        $word = $wordCompareService->getWordForTraining();

        return $this->render('word/check.html.twig', [
            'form' => $factory->create($word, $this->generateUrl('app_word_check')),
            'words' => $word->getTranslations()
        ]);
    }

    #[Route('/word-check', name: 'app_word_check', methods: ['POST'])]
    public function check(
        Request $request,
        WordCompareService $wordCompareService,
        TranslatorInterface $translator,
        WordsCompareFormFactory $factory
    ): Response
    {
        $word = new Word();

        $form = $factory->create($word, $this->generateUrl('app_word_check'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getData();

            if ($wordCompareService->checkWordTranslation($word)) {
                return $this->redirectToRoute('app_word_success');
            }

            $form->addError(new FormError($translator->trans('translation_error')));
        }

        return $this->render('word/check.html.twig', [
            'form' => $form,
            'words' => $wordCompareService->findOneByUuid($word->getUuid())
                ->getTranslations()
        ]);
    }
}