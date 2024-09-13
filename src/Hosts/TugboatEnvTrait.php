<?php

namespace kerasai\LampEnv\Hosts;

use kerasai\LampEnv\Env;

/**
 * Trait to detect Tugboat environments.
 */
trait TugboatEnvTrait {

  /**
   * Detect the Tugboat environment.
   *
   * @return array|null
   *   The environment info.
   */
  protected function detectTugboat() {
    if (getenv('TUGBOAT_ROOT')) {
      return [
        'env' => getenv('TUGBOAT_PREVIEW'),
        'host' => 'tugboat',
        'mode' => Env::MODE_TEST,
        'name' => 'Tugboat ' . getenv('TUGBOAT_PREVIEW'),
      ];
    }
    return NULL;
  }
}
