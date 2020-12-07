<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;

/**
 * Class ConsumerIdType
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type
 */
class ConsumerIdType extends IdentityType
{
    protected const NAME = 'consumer_id';

    /** {@inheritDoc} */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ConsumerId($value);
    }
}
