<?php

namespace App\DataFixtures;

use App\Entity\Translation;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WordFixtures extends Fixture
{
    private array $data;

    public function __construct()
    {
        $this->data = json_decode(file_get_contents(__DIR__ . '/translations.json'), true);
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $data) {
            $word = new Word();

            $word->setComplexity(0)
                ->setLevel(0);

            foreach ($data as $key => $translationData) {
                $translation_sv = new Translation();

                $translation_sv->setWord($word)
                    ->setTitle($key)
                    ->setLanguage('sv');

                $manager->persist($translation_sv);

                foreach ($translationData as $transWord) {
                    $translation_ru = new Translation();

                    $translation_ru->setWord($word)
                        ->setTitle($transWord)
                        ->setLanguage('ru');

                    $manager->persist($translation_ru);
                }
            }

            $manager->persist($word);
        }

        $manager->flush();
    }
}
