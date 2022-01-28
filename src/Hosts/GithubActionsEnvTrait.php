<?php

namespace kerasai\LampEnv\Hosts;

use kerasai\LampEnv\Env;

/**
 * Trait to detect Github Actions environments.
 */
trait GithubActionsEnvTrait {

  /**
   * Detect the Github Actions environment.
   *
   * @return array|null
   *   The environment info.
   */
  protected function detectGithubActions() {
    if (getenv('CI') === 'GITHUB') {
      return [
        'env' => getenv('GITHUB_WORKFLOW') . '--' . getenv('GITHUB_RUN_NUMBER'),
        'host' => 'github_actions',
        'mode' => Env::MODE_TEST,
        'name' => getenv('GITHUB_WORKFLOW') . '--' . getenv('GITHUB_RUN_NUMBER'),
      ];
    }
    return NULL;
  }

}
