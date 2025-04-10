<?php

namespace Drupal\omkar_hooks_events\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Drupal\node\NodeInterface;

/**
 * Event triggered when a blog is published.
 */
class BlogPublishedEvent extends Event {

  public const EVENT_NAME = 'omkar_hooks_events.blog_published';

  protected NodeInterface $node;

  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }

  /**
   *
   */
  public function getNode(): NodeInterface {
    return $this->node;
  }

}
