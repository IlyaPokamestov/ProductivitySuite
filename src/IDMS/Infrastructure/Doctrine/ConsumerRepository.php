<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\ConsumerRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\Consumer as ReadOnlyConsumer;

/**
 * Class ConsumerRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine
 *
 * At the moment the repository used to handle both write and read models (in terms of CQRS)
 * The idea of CQRS that we can split write and read models, so that write model for example can use relational DB,
 * read model can be in non-normalized form and use nosql storage. (also called Projections)
 */
class ConsumerRepository extends ServiceEntityRepository implements WriteRepository, ReadRepository
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
    public function findById(string $id): ReadOnlyConsumer
    {
        $consumer = $this->findConsumerById(new ConsumerId($id));

        return new ReadOnlyConsumer(
            (string) $consumer->getId(),
            $consumer->getName()->getUsername(),
            $consumer->getName()->getFirstName(),
            $consumer->getName()->getLastName(),
            (string) $consumer->getEmail(),
            (string) $consumer->getStatus()
        );
    }

    /** {@inheritDoc} */
    public function findConsumerById(ConsumerId $id): Consumer
    {
        /** @var Consumer|null $consumer */
        $consumer = $this->find((string) $id);

        if (null === $consumer) {
            throw new EntityNotFoundException('Consumer not found!');
        }

        return $consumer;
    }
}
