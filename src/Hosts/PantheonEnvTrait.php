<?php

namespace kerasai\LampEnv\Hosts;

use kerasai\LampEnv\Env;

/**
 * Trait to detect Pantheon environments.
 */
trait PantheonEnvTrait {

  /**
   * Detect the Pantheon environment.
   *
   * If running in conjunction with Lando, you'll want to use the trait to
   * detect Lando first.
   *
   * @return array|null
   *   The environment info.
   */
  public function detectPantheon() {
    if (getenv('PANTHEON_ENVIRONMENT')) {
      $info = [
        'host' => 'pantheon',
        'env' => getenv('PANTHEON_ENVIRONMENT'),
      ];

      switch ($info['env']) {
        case 'dev':
          $info['mode'] = Env::MODE_DEV;
          $info['name'] = 'Test';
          break;

        case 'test':
          $info['mode'] = Env::MODE_TEST;
          $info['name'] = 'Test';
          break;

        case 'live':
          $info['mode'] = Env::MODE_LIVE;
          $info['name'] = 'Live';
          break;

        default:
          $info['mode'] = Env::MODE_DEV;
          $info['name'] = 'Multidev ' . $info['env'];
      }

      return $info;
    }
    return NULL;
  }

}
