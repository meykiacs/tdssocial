<?php

declare(strict_types=1);

namespace TdSocial\Validate;

interface ValidatorInterface {
  public function validate($value): bool;
}
