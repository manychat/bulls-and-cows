<?php

declare(strict_types=1);

namespace Src\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SmallIntType;
use Src\Model\Game\Entity\Common\Figures;

final class FiguresType extends SmallIntType
{
    public const NAME = 'figures';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Figures ? $value->getFigures() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return empty($value) ? null : new Figures($value);
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
