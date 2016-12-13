<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

use Nette\Utils\DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Model\Entity
 *
 * @ORM\Table(name="Translations")
 * @ORM\Entity
 */
class Translation extends AbstractEntity
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string")
     */
    protected $originalString;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string")
     */
    protected $translatedString;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getOriginalString()
    {
        return $this->originalString;
    }

    /**
     * @param string $originalString
     */
    public function setOriginalString($originalString)
    {
        $this->originalString = $originalString;
    }

    /**
     * @return string
     */
    public function getTranslatedString()
    {
        return $this->translatedString;
    }

    /**
     * @param string $translatedString
     */
    public function setTranslatedString($translatedString)
    {
        $this->translatedString = $translatedString;
    }
}
