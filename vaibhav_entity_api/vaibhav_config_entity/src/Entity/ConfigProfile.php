<?php

declare(strict_types=1);

namespace Drupal\vaibhav_config_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\vaibhav_config_entity\ConfigProfileInterface;

/**
 * Defines the config profile entity type.
 *
 * @ConfigEntityType(
 *   id = "config_profile",
 *   label = @Translation("Config Profile"),
 *   label_collection = @Translation("Config Profiles"),
 *   label_singular = @Translation("config profile"),
 *   label_plural = @Translation("config profiles"),
 *   label_count = @PluralTranslation(
 *     singular = "@count config profile",
 *     plural = "@count config profiles",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\vaibhav_config_entity\ConfigProfileListBuilder",
 *     "form" = {
 *       "add" = "Drupal\vaibhav_config_entity\Form\ConfigProfileForm",
 *       "edit" = "Drupal\vaibhav_config_entity\Form\ConfigProfileForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "config_profile",
 *   admin_permission = "administer config_profile",
 *   links = {
 *     "collection" = "/admin/structure/config-profile",
 *     "add-form" = "/admin/structure/config-profile/add",
 *     "edit-form" = "/admin/structure/config-profile/{config_profile}",
 *     "delete-form" = "/admin/structure/config-profile/{config_profile}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "code",
 *   },
 * )
 */
final class ConfigProfile extends ConfigEntityBase implements ConfigProfileInterface {

  /**
   * The example ID.
   */
  protected string $id;

  /**
   * The example label.
   */
  protected string $label;

  /**
   * The example description.
   */
  protected string $description;

  /**
   * Code.
   *
   * @var string
   */
  protected $code;

  /**
   * {@inheritdoc}
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * {@inheritdoc}
   */
  public function setCode($code) {
    // Convert to lowercase.
    $code = strtolower($code);
    // Set the new value.
    $this->set('code', $code);
    return $this;
  }

}
