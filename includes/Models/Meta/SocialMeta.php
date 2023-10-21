<?php

declare(strict_types=1);

namespace TdSocial\Models\Meta;

use TdSocial\CPTResource\Model\Meta;

class SocialMeta extends Meta {

  public string $slug = 'social';
  public string $type = 'object';


  public array $schema = [
    'type'  => 'object',
    'properties'  => [
      'twitter'  =>  [
        'type'  =>  'string',
      ],
      'instagram'  =>  [
        'type'  =>  'string',
      ],
      'phone'  =>  [
        'type'  =>  'string',
      ],
      'whatsapp'  =>  [
        'type'  =>  'string',
      ],
      'email'  =>  [
        'type'  =>  'string',
        'format'  => 'email'
      ],
      'linkedin'  =>  [
        'type'  =>  'string',
      ],
      'eeta'  =>  [
        'type'  =>  'string',
      ],
      'telegram'  =>  [
        'type'  =>  'string',
      ],
    ]
  ];
}
