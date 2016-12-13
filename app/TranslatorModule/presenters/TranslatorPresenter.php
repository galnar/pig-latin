<?php

namespace App\TranslatorModule\Presenters;

use App\Presenters\BasePresenter;

class TranslatorPresenter extends BasePresenter
{
    const VOWELS = ['a', 'e', 'i', 'o', 'u'];
    const VOWEL_END = 'way';
    const CONSONANT_END = 'ay';

	public function renderDefault()
	{
        $stringToTranslate = "Some test string used for testing functionality of pig latin translator";
        dump($stringToTranslate);
        $translatedString = $this->translateString(strtolower($stringToTranslate), true);
        dump($translatedString);
        $translatedString = $this->translateString($translatedString, false);
        dump($translatedString);
	}

    /**
     * Translate given string to Pig Latin
     *
     * @param string $string
     * @param bool $toPig
     * @return string
     */
	private function translateString($string, $toPig)
    {
        $translatedString = "";
        $wordList = explode(" ", $string);

        foreach ($wordList as $word)
        {
            $translatedString .=
                $toPig ? $this->translateWordToPigLatin($word) : $this->translateWordFromPigLatin($word);

            // adding gaps between words
            if ($word !== end($wordList)) {
                $translatedString .= " ";
            }
        }

        return $translatedString;
    }

    /**
     * Translate given word to Pig Latin
     *
     * @param string $word
     * @return string
     */
    private function translateWordToPigLatin($word)
    {
        $firstLetter = substr($word, 0, 1);

        if (in_array($firstLetter, self::VOWELS)) {
            $translatedWord = $word . self::VOWEL_END;
        } else {
            $consonantWord = substr(strtolower($word), 1);
            $translatedWord = $consonantWord . $firstLetter . self::CONSONANT_END;
        }

        return $translatedWord;
	}

    /**
     * Translate given word from Pig Latin
     *
     * @param string $word
     * @return string
     */
	private function translateWordFromPigLatin($word)
    {
        $wordEnd = substr($word, -3);
        $translatedWord = substr($word, 0, -3);
        if ($wordEnd !== self::VOWEL_END) {
            $lastLetterFromTemp = substr($word, -3, 1);
            $translatedWord = $lastLetterFromTemp . $translatedWord;
        }

        return $translatedWord;
    }

}
