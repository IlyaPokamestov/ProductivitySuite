<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type;

use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Identity;

/**
 * Class IdentityType
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type
 */
class IdentityType extends GuidType
{
    protected const NAME = 'identity';

    /** {@inheritDoc} */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Identity($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    /** {@inheritDoc} */
    public function getName()
    {
        return self::NAME;
    }
}
