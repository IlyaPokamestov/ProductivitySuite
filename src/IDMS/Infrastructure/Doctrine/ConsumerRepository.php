<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Class ConsumerRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine
 */
class ConsumerRepository extends ServiceEntityRepository implements WriteRepository
{
    /** {@inheritDoc} */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consumer::class);
    }

    /** {@inheritDoc} */
    public function save(Consumer $consumer): void
    {
        $this->getEntityManager()->persist($consumer);
        $this->getEntityManager()->flush($consumer);
    }

    /** {@inheritDoc} */
    public function findById(ConsumerId $id): Consumer
    {
        /** @var Consumer|null $consumer */
        $consumer = $this->find((string) $id);

        if (null === $consumer) {
            throw new EntityNotFoundException('Consumer not found!');
        }

        return $consumer;
    }
}
