<?php

declare(strict_types=1);

namespace Src\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Src\Model\Game\Entity\Game\Level;

final class LevelType extends Type
{
    public const NAME = 'level';

    private const DEFAULT_LENGTH = 4;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Level ? $value->getLevel() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Level
    {
        return empty($value) ? null : new Level($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        if (null === $fieldDeclaration['length']) {
            $fieldDeclaration['length'] = self::DEFAULT_LENGTH;
        }

        $fieldDeclaration['fixed'] = true;

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }
}
