<?php

namespace Drupal\omkar_cache_api\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\node\Event\NodeEvent;
use Drupal\omkar_cache_api\Service\BlogCacheService;

/**
 * Event Subscriber to clear cache when a blog post is created or updated.
 */
class BlogEventSubscriber implements EventSubscriberInterface {

  protected $blogCacheService;

  public function __construct(BlogCacheService $blogCacheService) {
    $this->blogCacheService = $blogCacheService;
  }

  /**
   *
   */
  public static function getSubscribedEvents() {
    return [
      'entity.node.insert' => 'clearBlogCache',
      'entity.node.update' => 'clearBlogCache',
      'entity.node.delete' => 'clearBlogCache',
    ];
  }
  

  /**
   * Clears the cache when a blog post is added or updated.
   */
  public function clearBlogCache($event) {
    $node = $event->getNode();
    if ($node->bundle() == 'blog') {
      $this->blogCacheService->clearCache();
    }
  }

}
