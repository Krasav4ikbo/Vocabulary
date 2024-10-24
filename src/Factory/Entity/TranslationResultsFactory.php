<?php
namespace App\Factory\Entity;

use App\Entity\TranslationResults;
use App\Entity\Word;

class TranslationResultsFactory
{
    public function createDefault(Word $word): TranslationResults
    {
        $entity = new TranslationResults();

        $entity->setWord($word);

        $entity->setSucceed(0);

        $entity->setFailed(0);

        return $entity;
    }
}