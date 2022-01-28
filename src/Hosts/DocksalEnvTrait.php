<?php

namespace kerasai\LampEnv\Hosts;

use kerasai\LampEnv\Env;

/**
 * Trait to detect Docksal environments.
 */
trait DocksalEnvTrait {

  /**
   * Detect the Docksal environment.
   *
   * Requires setting IS_DOCKSAL=1 as an environment variable in the cli
   * service.
   *
   * @return array|null
   *   The environment info.
   */
  protected function detectDocksal() {
    if (getenv('IS_DOCKSAL')) {
      return [
        'env' => 'docksal',
        'host' => 'docksal',
        'mode' => Env::MODE_DEV,
        'name' => 'Docksal',
      ];
    }
    return NULL;
  }

}
