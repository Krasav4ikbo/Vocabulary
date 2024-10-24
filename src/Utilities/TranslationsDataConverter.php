<?php
namespace App\Utilities;

class TranslationsDataConverter
{
    public int $result = 0;

    public string $content;

    public array $table = [];

    public function init($input): void
    {
        $this->readFile($input);
        $this->prepareData();
        $this->execute();
    }

    public function prepareData(): void
    {
        $this->table = explode(PHP_EOL, $this->content);
    }

    public function readFile($path): void
    {
        $this->content = file_get_contents($path);
    }

    public function execute(): void
    {
        $new_words = [];
        foreach ($this->table as $row) {
            $words = explode(' – ', $row);
            $new_words[]=[
                $words[0] => $this->getTranslations($words[1]),
            ];

        }
        var_dump($new_words);

        file_put_contents('./translations.json', json_encode($new_words, JSON_PRETTY_PRINT));
    }

    public function getTranslations($phrase): array
    {
        if(strpos($phrase, '(')) {
            $phrase = preg_replace('~\s{1,}\(~', '(', $phrase);
            $phrase = preg_replace('~\(.*\),~', '', $phrase);
            $phrase = preg_replace('~\(.*\)~', '', $phrase);
        }

        $translations = [];

        foreach (explode(' ', $phrase) as $word) {
            $oneWord = $this->trim($word);

            if(!in_array($oneWord, $translations)) {
                $translations[]=$this->trim($word);
            }
        }

        return $translations;
    }

    public function trim($word): string
    {
        $word = str_replace(',', '', $word);
        $word = str_replace(';', '', $word);
        $word = str_replace(':', '', $word);
        $word = trim($word);
        return $word;
    }
}