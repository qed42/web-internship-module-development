<?php

declare(strict_types=1);

namespace Drupal\Omkar_RenderAPI_blog_categories\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a 'Blog Tags Sidebar' Block.
 *
 * @Block(
 *   id = "blog_tags_block",
 *   admin_label = @Translation("Blog Tags Sidebar"),
 *   category = @Translation("Custom")
 * )
 */
class BlogCategoriesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a BlogCategoriesBlock object.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

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
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('tags');

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
