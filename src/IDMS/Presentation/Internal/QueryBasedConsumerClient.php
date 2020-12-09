<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindConsumerById;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Class QueryBasedConsumerClient
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal
 */
class QueryBasedConsumerClient implements ConsumerClient
{
    private const UNKNOWN = 'UNKNOWN';

    /** @var QueryBusInterface */
    private QueryBusInterface $queryBus;

    /**
     * QueryBasedConsumerClient constructor.
     * @param QueryBusInterface $queryBus
     */
    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /** {@inheritDoc} */
    public function consumerStatus(string $consumerId): string
    {
        try {
            /** @var ConsumerReadModel $consumer */
            $consumer = $this->queryBus->query(new FindConsumerById($consumerId));

            return $consumer->getStatus();
        } catch (EntityNotFoundException $exception) {
            //ignore
        }

        return self::UNKNOWN;
    }
}
