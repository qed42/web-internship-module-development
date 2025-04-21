<?php

namespace Drupal\omkar_cache_api\Service;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Service to cache and retrieve latest blog posts.
 */
class BlogCacheService {

  protected CacheBackendInterface $cacheBackend;
  protected EntityTypeManagerInterface $entityTypeManager;
  protected LoggerInterface $logger;

  /**
   * Constructor to inject dependencies.
   */
  public function __construct(
    CacheBackendInterface $cache_backend,
    EntityTypeManagerInterface $entity_type_manager,
    LoggerInterface $logger
  ) {
    $this->cacheBackend = $cache_backend;
    $this->entityTypeManager = $entity_type_manager;
    $this->logger = $logger;
  }

  /**
   * Fetch latest blog posts from cache or database.
   */
  public function getLatestBlogs($limit = 5): array {
    $cid = 'omkar_cache_api:latest_blogs';
    $cache = $this->cacheBackend->get($cid);

    if ($cache) {
      $this->logger->notice('Cache HIT: Returning cached data.');
      return $cache->data;
    }
    else {
      $this->logger->notice('Cache MISS: Fetching from database.');

      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('status', 1)
        ->condition('type', 'blog')
        ->sort('created', 'DESC')
        ->range(0, $limit)
        ->accessCheck(TRUE);

      $nids = $query->execute();
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

      $blogs = [];
      foreach ($nodes as $node) {
        $blogs[] = [
          'title' => $node->getTitle(),
          'url' => $node->toUrl()->toString(),
        ];
      }

      $this->cacheBackend->set($cid, $blogs, CacheBackendInterface::CACHE_PERMANENT, ['node_list']);

      return $blogs;
    }
  }

  /**
   * Clears the cache when a blog post is updated.
   */
  public function clearCache(): void {
    $this->cacheBackend->invalidate('omkar_cache_api:latest_blogs');
  }

}
