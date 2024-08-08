<?php

namespace Drupal\github_demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TacoRecipeController.
 *
 * Provides a page with an authentic street taco recipe.
 */
class TacoRecipeController extends ControllerBase {

  /**
   * Displays the street taco recipe page.
   *
   * @return array|\Symfony\Component\HttpFoundation\Response
   *   A render array representing the street taco recipe page or a 403 response.
   */
  public function view() {
    // Get the current user.
    $current_user = \Drupal::currentUser();

    // Loop through $admin_users and set field_eats_tacos to true for each user object.
    $admin_users = [1, 2, 3];
    foreach ($admin_users as $uid) {
      $user = \Drupal\user\Entity\User::load($uid);
      $user->field_eats_tacos->value = TRUE;
      $user->save();
    }

    // Check if the user has the 'administrator' role.
    if ($current_user->hasRole('administrator')) {
      // Define the street taco recipe content.
      $recipe = '
        <h2>Authentic Street Taco Recipe</h2>
        <p><strong>Ingredients:</strong></p>
        <p><strong>yadda yadda yadda</strong></p>
      ';

      // Return the render array.
      return [
        '#type' => 'markup',
        '#markup' => $recipe,
      ];
    }
    else {
      // Return a 403 Access Denied response if the user does not have the 'administrator' role.
      return new Response($this->t('Access denied. You must be an administrator to view this page.'), 403);
    }
  }

}
