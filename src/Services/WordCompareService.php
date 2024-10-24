<?php

namespace App\Services;

use App\Entity\Word;
use App\Repository\WordRepository;
use Ramsey\Uuid\Uuid;

class WordCompareService
{
    private WordRepository $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function findOneByUuid($uuid): ?Word
    {
        return $this->wordRepository->findOneBy(['uuid' => $uuid]);
    }

    public function getWordWithTranslations():array
    {
        $word = $this->wordRepository->findOneRandom();

        foreach ($word->getTranslations() as $translation) {
            $translations[$translation->getLanguage()][] = $translation->getTitle();
        }

        return $translations;
    }

    public function getWordForTraining():Word
    {
        return $this->wordRepository->findOneRandom();
    }

    public function getWordTranslationByLanguage(Word $word, string $language): string
    {
        return $this->getAllTranslations($word)[$language][0] ?? '';
    }

    public function checkWordTranslation(string $uuid, string $translation): bool
    {
        $word = $this->findOneByUuid(['uuid' => $uuid]);

        $translations = $this->getAllTranslations($word);

        return in_array($translation, $translations['ru']);
    }

    public function getAllTranslations(Word $word):array
    {
        foreach ($word->getTranslations() as $translation) {
            $translations[$translation->getLanguage()][] = $translation->getTitle();
        }

        return $translations ?? [];
    }

    public function markTranslationAsSuccess($word): void
    {

    }

    public function markTranslationAsFailed($word): void
    {
    }
}