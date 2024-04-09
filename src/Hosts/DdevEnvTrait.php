<?php

namespace kerasai\LampEnv\Hosts;

/**
 * Trait to detect DDEV environments.
 */
trait DdevEnvTrait {

  /**
   * Detect the DDEV environment.
   *
   * @return array|null
   *   The environment info.
   */
  public function detectDdev() {
    if (getenv('IS_DDEV_PROJECT') == 'true') {
      return [
        'env' => 'ddev',
        'host' => 'ddev',
        'mode' => Env::MODE_DEV,
        'name' => 'DDEV',
      ];
    }
    return NULL;
  }

}
