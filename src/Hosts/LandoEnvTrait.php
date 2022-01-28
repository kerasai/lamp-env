<?php

namespace kerasai\LampEnv\Hosts;

use kerasai\LampEnv\Env;

/**
 * Trait to detect Lando environments.
 */
trait LandoEnvTrait {

  /**
   * Detect the Lando environment.
   *
   * @return array|null
   *   The environment info.
   */
  public function detectLando() {
    if (getenv('LANDO_APP_NAME')) {
      return [
        'env' => 'lando',
        'host' => 'lando',
        'mode' => Env::MODE_DEV,
        'name' => 'Lando',
      ];
    }
    return NULL;
  }

}
