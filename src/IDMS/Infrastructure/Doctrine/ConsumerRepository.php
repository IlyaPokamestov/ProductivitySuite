<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine;

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
class ConsumerRepository implements WriteRepository, ReadRepository
{
    /** @var array */
    private array $consumers = [];

    /** {@inheritDoc} */
    public function save(Consumer $consumer): void
    {
        $this->consumers[(string) $consumer->getId()] = $consumer;
    }

    /** {@inheritDoc} */
    public function findById(string $id): ReadOnlyConsumer
    {
        if ('aaa279e0-230b-4179-b339-bd091bf27a77' === $id) {
            return new ReadOnlyConsumer(
                'aaa279e0-230b-4179-b339-bd091bf27a77',
                'Test',
                'Test',
                'Test',
                'test@test.com',
            );
        }

        /** @var Consumer $consumer */
        $consumer = $this->consumers[(string) $id] ?? null;
        if (null === $consumer) {
            throw new EntityNotFoundException('Consumer not found!');
        }

        return new ReadOnlyConsumer(
            (string) $consumer->getId(),
            $consumer->getName()->getUsername(),
            $consumer->getName()->getFirstName(),
            $consumer->getName()->getLastName(),
            (string) $consumer->getEmail(),
        );
    }
}
