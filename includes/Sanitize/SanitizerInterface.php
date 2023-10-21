<?php

declare(strict_types=1);

namespace TdSocial\Sanitize;

interface SanitizerInterface {
  public function sanitize($value);
}
