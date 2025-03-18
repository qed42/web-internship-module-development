<?php

declare(strict_types=1);

namespace Drupal\omkar_pluginapi;

//Interface for Drupal's caching system.Used to cache plugin discovery results.
use Drupal\Core\Cache\CacheBackendInterface; 

//Interface for interacting with enabled modules.Helps call hook implementations or alter functions.
use Drupal\Core\Extension\ModuleHandlerInterface;

// Base class for most plugin managers in Drupal.
// Provides core logic for plugin discovery, instantiation, caching, etc.
use Drupal\Core\Plugin\DefaultPluginManager;

// This is your custom annotation class used to tag plugin classes.
// Needed so Drupal knows how to read metadata from plugins.
use Drupal\omkar_pluginapi\Annotation\OmkarPluginapi;

/**
 * OmkarPluginapi plugin manager.
 */
final class OmkarPluginapiPluginManager extends DefaultPluginManager {

  /**
   * Constructs the object.
   */

//    \Traversable $namespaces
// A list of available namespaces in the codebase.
// Used to scan for plugin classes in subdirectories like Plugin/OmkarPluginapi.
// CacheBackendInterface $cache_backend
// Drupal's cache backend service.
// Used to store plugin discovery results for performance.
// ModuleHandlerInterface $module_handler
// Service to interact with Drupal modules.
// Used to run hook implementations or alter plugin definitions.
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
// 'Plugin/OmkarPluginapi' → folder path to look for plugins.
// $namespaces → namespaces to search within.
// $module_handler → for alter hooks.
// OmkarPluginapiInterface::class → expected interface plugins must implement.
// OmkarPluginapi::class → annotation class used for discovery.
    parent::__construct('Plugin/OmkarPluginapi', $namespaces, $module_handler, OmkarPluginapiInterface::class, OmkarPluginapi::class);
    // Enables hook_alter support.
    $this->alterInfo('omkar_pluginapi_info');

//     $this->setCacheBackend($cache_backend, 'omkar_pluginapi_plugins');
// Sets up caching for plugin discovery.
// 'omkar_pluginapi_plugins' is the cache bin name (unique ID for storing cache entries).
    $this->setCacheBackend($cache_backend, 'omkar_pluginapi_plugins');
  }

}
