<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type\IdentityType;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;

/**
 * Class OwnerIdType
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Type
 */
final class OwnerIdType extends IdentityType
{
    protected const NAME = 'owner_id';

    /** {@inheritDoc} */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new OwnerId($value);
    }
}
