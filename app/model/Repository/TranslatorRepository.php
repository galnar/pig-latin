<?php
namespace App\Model\Repository;

use App\Model\Entity\Translation;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\EntityManager;

class TranslatorRepository extends AbstractRepository
{
    /** @var EntityManager */
    protected $translation;

    /**
     * TranslatorRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->translation = $this->entityManager->getRepository(Translation::class);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Translation[]|ArrayCollection|null
     */
    public function getBy($criteria, $orderBy = null, $limit = null, $offset = null)
    {
        return new ArrayCollection($this->translation->findBy($criteria, $orderBy, $limit, $offset));
    }
}
