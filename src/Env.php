<?php

namespace kerasai\LampEnv;

/**
 * Environment detection utility.
 */
class Env {

  // Dev mode for environments that are not test or live.
  const MODE_DEV = 'dev';

  // Test mode for environments that are not developed on.
  const MODE_TEST = 'test';

  // Live mode for production.
  const MODE_LIVE = 'live';

  /**
   * Singleton instance.
   *
   * @var Env
   */
  protected static $env;

  /**
   * The environment info.
   *
   * Only populated as needed. Call ::getInfo to populate and access this.
   *
   * @var array|null
   */
  protected $info;

  /**
   * Create an env detection object.
   *
   * @return \kerasai\LampEnv\Env
   *   The env detection object.
   */
  public static function create(): Env {
    if (!static::$env) {
      static::$env = new static();
    }
    return static::$env;
  }

  /**
   * Get the environment info.
   *
   * @return array
   *   The environment info.
   */
  public function getInfo(): array {
    if ($this->info === NULL) {
      $this->info = $this->detectInfo();
      // Set the name if not set by ::detect.
      if (empty($this->info['name'])) {
        $this->info['name'] = empty($this->info['env']) ? 'Unknown' : ucwords($this->info['env']);
      }
    }
    return $this->info;
  }

  /**
   * Detect the environment info.
   *
   * @return array
   *   The environment info.
   */
  protected function detectInfo(): array {
    return [
      'env' => NULL,
      'host' => NULL,
      'mode' => NULL,
    ];
  }

  /**
   * Get the environment ID.
   *
   *
   *
   * @return string|null
   *   The environment ID, or NULL if not detected.
   */
  public function getEnv() {
    return $this->getInfo()['env'];
  }

  /**
   * Get the environment host.
   *
   * @return string|null
   *   The environment host, or NULL if not detected.
   */
  public function getHost() {
    return $this->getInfo()['host'];
  }

  /**
   * Get the environment mode.
   *
   * @return string|null
   *   The environment mode, or NULL if not detected.
   */
  public function getMode() {
    return $this->getInfo()['mode'];
  }

  /**
   * Get the environment name.
   *
   * @return string
   *   The environment name.
   */
  public function getName() {
    return $this->getInfo()['name'];
  }

  /**
   * Gets the possible file names to include.
   *
   * This is set up to include Drupal settings files, in the following order:
   *
   * - Project-wide settings:             settings.default.php
   * - Mode specific settings:            settings.{mode}.php
   * - Host specific settings:            settings.{host}.php
   * - Host and mode specific settings:   settings.{host}.{mode}.php
   *
   * @param string $separator
   *   Separator used to join filenames.
   * @param string $extension
   *   The extension to use for the file.
   * @param string $prefix
   *   Prefix to begin to the filename.
   * @param string $suffix
   *   Suffix to append to the filename.
   *
   * @return array
   *   Names of possible files include.
   */
  public function getIncludes($separator = '.', $extension = 'php', $prefix = 'settings', $suffix = ''): array {
    if ($suffix) {
      $extension = "$suffix.$extension";
    }

    $includes = [[$prefix, 'default', "$extension"]];

    if ($mode = $this->getMode()) {
      $includes[] = [$prefix, $mode, "$extension"];
    }

    if ($host = $this->getHost()) {
      $includes[] = [$prefix, $host, "$extension"];
      if ($mode) {
        $includes[] = [$prefix, "$host$separator$mode", "$extension"];
      }
    }

    $includes = array_map(function ($include) use ($separator) {
      return implode($separator, array_filter($include));
    }, $includes);

    return array_filter($includes);
  }

  /**
   * Require the includes.
   *
   * @param string $directory
   *   The directory containing the files.
   * @param string $separator
   *   Separator used to join filenames.
   * @param string $extension
   *   The extension to use for the file.
   * @param string $prefix
   *   Prefix to begin to the filename.
   * @param string $suffix
   *   Suffix to append to the filename.
   */
  public function requireIncludes(string $directory, $separator = '.', $extension = 'php', $prefix = 'settings', $suffix = '') {
    $directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    foreach ($this->getIncludes($separator, $extension, $prefix, $suffix) as $include) {
      if (is_readable($directory . $include)) {
        require $directory . $include;
      }
    }
  }

}
