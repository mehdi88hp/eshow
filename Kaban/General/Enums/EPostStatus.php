<?php

namespace Kaban\General\Enums;


use Kaban\Core\Enums\BaseEnum;

class EPostStatus extends BaseEnum {
    const pending = 1;
    const approved = 2;
    const ignored = 3;
    const rejected = 4;
}
