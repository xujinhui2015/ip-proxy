<?php

namespace App\Enums\Proxy;

use App\Support\Traits\EnumTrait;

enum ProxyExtractPriorityEnum: int
{
    use EnumTrait;

    case Pool = 1;
    case Ip = 2;

    public function text(): string
    {
        return match ($this) {
            self::Pool => '代理池',
            self::Ip => '代理ip',
        };
    }
}
