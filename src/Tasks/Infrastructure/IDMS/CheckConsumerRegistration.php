<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\IDMS;

use IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal\ConsumerClient;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnerRegisteredPolicy;

/**
 * Class CheckConsumerRegistration
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\IDMS
 *
 * This service depends on the presentational interface of other bounded context.
 * The same will be in case we will decide to split bounded contexts into separate applications.
 */
class CheckConsumerRegistration implements OwnerRegisteredPolicy
{
    private const ACTIVE_STATUS = 'ACTIVE';

    /** @var ConsumerClient */
    private ConsumerClient $consumerClient;

    /**
     * CheckConsumerStatus constructor.
     * @param ConsumerClient $consumerClient
     */
    public function __construct(ConsumerClient $consumerClient)
    {
        $this->consumerClient = $consumerClient;
    }

    /** {@inheritDoc} */
    public function verify(OwnerId $owner): void
    {
        $status = $this->consumerClient->consumerStatus((string) $owner);

        if ($status !== self::ACTIVE_STATUS) {
            throw new OwnershipMismatchException('Consumer is not registered!');
        }
    }
}
