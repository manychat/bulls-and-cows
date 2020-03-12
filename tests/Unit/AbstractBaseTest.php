<?php

declare(strict_types=1);

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Test\Helper\EntitiesManger;

abstract class AbstractBaseTest extends TestCase
{
    private EntitiesManger $entitiesManger;

    protected function getEntitiesManger(): EntitiesManger
    {
        if (!isset($this->entitiesManger)) {
            $this->entitiesManger = new EntitiesManger();
        }

        return $this->entitiesManger;
    }
}
