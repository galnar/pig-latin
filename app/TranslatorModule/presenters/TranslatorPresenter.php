<?php

namespace App\TranslatorModule\Presenters;

use App\Model\Entity\Translation;
use App\Model\Repository\TranslatorRepository;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;

/**
 * Class TranslatorPresenter
 * @package App\TranslatorModule\Presenters
 */
class TranslatorPresenter extends BasePresenter
{
    const FORM_COMPONENT_NAME = 'pigLatinTranslatorForm';
    const FORM_TEXT_INPUT = 'textInput';
    const FORM_SAVE_TO = 'translateToPigLatin';
    const FORM_SAVE_FROM = 'translateFromPigLatin';

    const VOWELS = ['a', 'e', 'i', 'o', 'u'];
    const VOWEL_END = 'way';
    const CONSONANT_END = 'ay';

    /** @var TranslatorRepository @inject */
    public $translatorRepository;


	public function renderDefault()
	{
        $this->template->lastTranslations = $this->translatorRepository->getBy([], ['date' => 'DESC'], 5);
	}

    /**
     * @return Form
     */
    protected function createComponentPigLatinTranslatorForm()
    {
        $form = new Form();
        $form->getElementPrototype()->class = 'ajax';

        $form->addTextArea(self::FORM_TEXT_INPUT, 'Text to translate')
            ->setAttribute('class', 'form-control');

        $form->addSubmit(self::FORM_SAVE_TO, 'Translate to Pig Latin')
            ->setAttribute('class', 'btn btn-primary');
        $form->addSubmit(self::FORM_SAVE_FROM, 'Translate from Pig Latin')
            ->setAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = [$this, 'pigLatinTranslatorFormSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     */
    public function pigLatinTranslatorFormSuccess(Form $form, $values)
    {
        $originalString = strtolower(trim($values[self::FORM_TEXT_INPUT]));
        $translatedString = $this->translateString(
            $originalString,
            $form->isSubmitted()->getName() === self::FORM_SAVE_TO ? true : false
        );

        $translation = new Translation();
        $translation->setDate(new DateTime());
        $translation->setOriginalString($originalString);
        $translation->setTranslatedString($translatedString);
        $this->translatorRepository->updateEntity($translation);

        $this->template->translatedText = $translatedString;
        $this->redrawControl();
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
