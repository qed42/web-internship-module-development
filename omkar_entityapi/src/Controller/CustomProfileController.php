<?php

namespace Drupal\omkar_entityapi\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller to handle custom profile functions.
 */
class CustomProfileController extends ControllerBase {

  /**
   * Builds the response.
   *
   * @return array
   *   A render array.
   */
  public function build() {
    $output = [];

    try {
      // Read.
      $custom_profile = $this->entityTypeManager()->getStorage('omkar_entityapi_profile')->load(2);

      if ($custom_profile) {
        $title = $custom_profile->label();
        $status = $custom_profile->status->value;
        $uid = $custom_profile->uid->target_id;

        dpm($title);
        dpm($status);
        dpm($uid);

        // $custom_profile->set('label', 'Demo testing');
        // $custom_profile->save();
        $custom_profile->set('uid', '12');
        $custom_profile->save();
        
        $output['profile_info'] = [
          '#type' => 'details',
          '#title' => $this->t('Custom Profile Information'),
          '#open' => TRUE,
        ];

        $output['profile_info']['content'] = [
          '#theme' => 'item_list',
          '#items' => [
            $this->t('Title: @title', ['@title' => $title]),
            $this->t('Status: @status', ['@status' => $status ? 'Enabled' : 'Disabled']),
            // $this->t('Description: @description', ['@description' => $description]),
            $this->t('User ID: @uid', ['@uid' => $uid]),
          ],
        ];
      }
      else {
        $output['no_profile'] = [
          '#markup' => $this->t('No custom profile found with ID 1.'),
        ];
      }
    }
    catch (\Exception $e) {
      $output['error'] = [
        '#markup' => $this->t('Error loading profile: @error', ['@error' => $e->getMessage()]),
      ];
    }

    try {
      // Update.
      $custom_profile = $this
        ->entityTypeManager()
        ->getStorage('custom_profile')
        ->load(1);
      $custom_profile->set('label', 'Updated title')->save();
    }
    catch (\Throwable $th) {
      // Throw $th;.
    }

    try {
      // Delete.
      $arr = [2, 4, 5, 6, 7, 8, 9];

      foreach ($arr as $key) {
        $custom_profile = $this
          ->entityTypeManager()
          ->getStorage('custom_profile')
          ->load($key);
        $custom_profile->delete();
      }
    }
    catch (\Throwable $th) {
      // Throw $th;.
    }

    try {
      // Create.
      // $custom_profile = $this->entityTypeManager()
      // ->getStorage('custom_profile')->create([
      // 'type' => 'custom_profile',
      // 'uid' => 2,
      // 'label' => 'New custom profile',
      // 'status' => 1,
      // 'description' => 'This is a new custom profile.',
      // ]);
      // $custom_profile->save();
    }
    catch (\Throwable $th) {
      // Throw $th;.
    }
    return $output;
  }

}
