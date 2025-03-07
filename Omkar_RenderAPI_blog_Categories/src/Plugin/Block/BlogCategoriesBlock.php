<?php

declare(strict_types=1);

namespace Drupal\Omkar_RenderAPI_blog_categories\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Provides a 'Blog Tags Sidebar' Block.
 *
 * @Block(
 *   id = "blog_tags_block",
 *   admin_label = @Translation("Blog Tags Sidebar"),
 *   category = @Translation("Custom")
 * )
 */
class BlogCategoriesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $tags = $this->getBlogTags();
  
    if (empty($tags)) {
      return [
        '#markup' => $this->t('No tags found.'),
      ];
    }
  
    $build = [
      '#theme' => 'links',
      '#links' => [],
      '#title' => $this->t('Tags'),
      '#attributes' => ['class' => ['blog-tags-sidebar']],
      '#cache' => [
        'tags' => ['taxonomy_term_list'],
        'max-age' => 3600,
      ],
      '#attached' => [
        'library' => [
          'blog_categories/blog_tags_styles',
        ],
      ],
    ];
  
    foreach ($tags as $tag) {
      $build['#links'][] = [
        'title' => $tag['name'],
        'url' => Url::fromUri('internal:' . $tag['url']),
        'attributes' => ['class' => ['tag-link']],
      ];
    }
  
    return $build;
  }
  

  /**
   * Get all taxonomy terms from the "tags" vocabulary.
   */
  private function getBlogTags(): array {
    $terms = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree('tags'); // 'tags' is your vocabulary name

    $tags = [];

    foreach ($terms as $term) {
      $tags[] = [
        'name' => $term->name,
        'url' => '/blog/tag/' . $term->tid,
      ];
    }

    return $tags;
  }
}
