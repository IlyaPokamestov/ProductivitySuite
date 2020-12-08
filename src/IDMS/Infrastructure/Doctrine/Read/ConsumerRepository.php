<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine\Read;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\ConsumerRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine\ConsumerRepository as WriteRepository;

/**
 * Class ConsumerReadRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine
 *
 * The idea of CQRS that we can split write and read models, so that write model for example can use relational DB,
 * read model can be in non-normalized form and use nosql storage. (also called Projections)
 */
class ConsumerRepository implements ReadRepository
{
    /** @var WriteRepository */
    private WriteRepository $repository;

    /**
     * ConsumerRepository constructor.
     * @param WriteRepository $repository
     */
    public function __construct(WriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function findById(string $id): Consumer
    {
        $consumer = $this->repository->findById(new ConsumerId($id));

        return new Consumer(
            (string) $consumer->getId(),
            $consumer->getName()->getUsername(),
            $consumer->getName()->getFirstName(),
            $consumer->getName()->getLastName(),
            (string) $consumer->getEmail(),
            (string) $consumer->getStatus()
        );
    }
}
