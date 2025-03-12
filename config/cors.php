<?php

return [
  'paths' => ['api/*'],
  'allowed_origins' => ['https://rust-one-frontend.vercel.app'],
  'allowed_methods' => ['*'],
  'allowed_headers' => ['*'],
  'exposed_headers' => [],
  'max_age' => 0,
  'supports_credentials' => true,
];