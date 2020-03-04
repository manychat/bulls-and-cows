<?php

declare(strict_types=1);

namespace Src\Game\Application\Move;

use Src\Shared\Domain\CommonRuntimeException;

final class LimitReachedException extends CommonRuntimeException
{
}
