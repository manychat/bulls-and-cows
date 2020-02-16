<?php

declare(strict_types=1);

namespace Src\Infrastructure\Doctrine\Type\Number;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SmallIntType;
use Src\Model\Game\Entity\Number;

final class NumberType extends SmallIntType
{
    public const NAME = 'number';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Number ? $value->getNumber() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return empty($value) ? null : new Number($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL([
            'unsigned' => true
        ]);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
