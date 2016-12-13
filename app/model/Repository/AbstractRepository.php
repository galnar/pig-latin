<?php
namespace App\Model\Repository;

use App\Model\Entity\AbstractEntity;
use Kdyby\Doctrine\EntityManager;
use Nette\Object;

abstract class AbstractRepository extends Object
{
    /** @var EntityManager */
    protected $entityManager;

    /**
     * AbstractRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AbstractEntity $entity
     */
    public function updateEntity(AbstractEntity $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param AbstractEntity $entity
     */
    public function deleteEntity(AbstractEntity $entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
