<?php

declare(strict_types=1);

namespace Src\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Src\Model\Common\Entity\Id\Id;

final class IdType extends GuidType
{
    public const NAME = 'id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof Id ? $value->getId() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        return empty($value) ? null : new Id($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
