<?php

declare(strict_types=1);

namespace Test\Helper;

use Symfony\Contracts\Translation\TranslatorInterface;

final class DummyTranslator implements TranslatorInterface
{
    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        return $id;
    }
}
