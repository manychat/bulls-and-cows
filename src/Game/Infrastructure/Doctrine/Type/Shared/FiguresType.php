<?php

declare(strict_types=1);

namespace Src\Game\Infrastructure\Doctrine\Type\Shared;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Src\Game\Domain\Shared\Figures;

final class FiguresType extends Type
{
    public const NAME = 'figures';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Figures ? $value->getFigures() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Figures
    {
        return empty($value) ? null : new Figures($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        $fieldDeclaration['length'] = Figures::LENGTH;
        $fieldDeclaration['fixed'] = true;

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
