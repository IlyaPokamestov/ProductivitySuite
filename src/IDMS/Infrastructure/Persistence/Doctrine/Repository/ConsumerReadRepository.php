<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Persistence\Doctrine\Repository;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel;

/**
 * Class ConsumerReadRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine
 *
 * The idea of CQRS that we can split write and read models, so that write model for example can use relational DB,
 * read model can be in non-normalized form and use nosql storage. (also called Projections)
 */
class ConsumerReadRepository implements ReadRepository
{
    /** @var ConsumerRepository */
    private ConsumerRepository $repository;

    /**
     * ConsumerRepository constructor.
     * @param ConsumerRepository $repository
     */
    public function __construct(ConsumerRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function findById(string $id): ConsumerReadModel
    {
        $consumer = $this->repository->findById(new ConsumerId($id));

        return new ConsumerReadModel(
            (string) $consumer->getId(),
            $consumer->getName()->getUsername(),
            $consumer->getName()->getFirstName(),
            $consumer->getName()->getLastName(),
            (string) $consumer->getEmail(),
            (string) $consumer->getStatus()
        );
    }
}
