<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type\IdentityType;

/**
 * Class ConsumerIdType
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Infrastructure\Doctrine\Type
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
