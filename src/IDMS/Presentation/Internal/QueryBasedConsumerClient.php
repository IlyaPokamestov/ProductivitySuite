<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindById;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\HandleTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Class QueryBasedConsumerClient
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal
 */
class QueryBasedConsumerClient implements ConsumerClient
{
    use HandleTrait;

    private const UNKNOWN = 'UNKNOWN';

    /** {@inheritDoc} */
    public function consumerStatus(string $consumerId): string
    {
        try {
            /** @var Consumer $consumer */
            $consumer = $this->query(new FindById($consumerId));

            return $consumer->getStatus();
        } catch (EntityNotFoundException $exception) {
            //ignore
        }

        return self::UNKNOWN;
    }
}
