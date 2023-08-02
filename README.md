# lamp-env
Library for environment detection.

## Usage

### Add Composer PSR-4 Autoloader

```
    "autoload": {
        "psr-4": {
            "MyProject\\": "src/"
        }
    }
```

### Create an `Env` class

Example Lando Env class `src/Env/Env.php`:

```
<?php

namespace MyProject\Env;

use kerasai\LampEnv\Env as BaseEnv;
use kerasai\LampEnv\Hosts\GithubActionsEnvTrait;
use kerasai\LampEnv\Hosts\LandoEnvTrait;

/**
 * Detect the environment.
 */
class Env extends BaseEnv {

  use GithubActionsEnvTrait;
  use LandoEnvTrait;

  /**
   * {@inheritdoc}
   */
  protected function detectInfo(): array {
    if ($lando = $this->detectLando()) {
      return $lando;
    }
    return $this->detectGithubActions() ?: parent::detectInfo();
  }

}
```
