<?php

namespace App\Services;

use App\Entity\Word;
use App\Factory\Entity\TranslationResultsFactory;
use App\Repository\TranslationResultsRepository;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;

class WordCompareService
{
    private WordRepository $wordRepository;

    private TranslationResultsRepository $translationResultsRepository;

    private EntityManagerInterface $entityManager;

    private TranslationResultsFactory $translationResultsFactory;

    public function __construct(
        WordRepository            $wordRepository,
        TranslationResultsRepository $translationResultsRepository,
        EntityManagerInterface    $entityManager,
        TranslationResultsFactory $translationResultsFactory
    )
    {
        $this->wordRepository = $wordRepository;
        $this->translationResultsRepository = $translationResultsRepository;
        $this->entityManager = $entityManager;
        $this->translationResultsFactory = $translationResultsFactory;
    }

    public function findOneByUuid($uuid): ?Word
    {
        return $this->wordRepository->find($uuid);
    }

    public function getWordForTraining(): Word
    {
        return $this->translationResultsRepository->findOneForTraining()->getWord();
    }

    public function checkWordTranslation(Word $data): bool
    {
        $word = $this->wordRepository->find($data->getUuid());

        $result = in_array($data->getTranslation(), $this->getAllTranslations($word)['ru']);

        $this->updateTransactionResults($word, $result);

        return $result;
    }

    public function getAllTranslations(Word $word): array
    {
        foreach ($word->getTranslations() as $translation) {
            $translations[$translation->getLanguage()][] = $translation->getTitle();
        }

        return $translations ?? [];
    }

    private function updateTransactionResults(Word $word, bool $result): void
    {
        $translationResult = $word->getTranslationResults()->first();

        if (!$translationResult) {
            $translationResult = $this->translationResultsFactory->createDefault($word);
        }

        if ($result) {
            $translationResult->succeedIncreece();
        } else {
            $translationResult->failedIncreece();
        }

        $this->entityManager->persist($translationResult);

        $this->entityManager->flush();
    }
}