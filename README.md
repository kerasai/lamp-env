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

### Drupal Settings File

```
<?php

$env = \MyProject\Env\Env::create();

foreach ($env->getIncludes() as $include) {
  $filename = __DIR__ . '/' . $include;
  if (file_exists($filename)) {
    include $filename;
  }
}

// Local settings overrides.
if (file_exists(__DIR__ . '/settings.local.php')) {
  include __DIR__ . '/settings.local.php';
}
```

### Specific settings files

* `settings.default.php`: Settings applicable to all environments
* `settings.[mode].php`: Settings applicable to a type of environment (dev/test/live)
* `settings.[host].php`: Settings applicable to a specific host (Lando, Pantheon, etc.)
* `settings.[host].[mode].php`: Settings applicable to a type of environment on a specific host
