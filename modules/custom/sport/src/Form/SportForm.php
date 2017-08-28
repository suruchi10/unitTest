<?php
/**
 * @file
 * Contains \Drupal\sport\Form\SportForm.
 */

namespace Drupal\sport\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use \Drupal\node\Entity\Node;

class SportForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'sport_form';
  }


  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $games = ['Indoor', 'Outdoor'];
    $form['game'] = array (
      '#type' => 'radios',
      '#title' => ('Which Type Of Game You Like?'),
      '#options' => array_combine($games,$games),
      
    );

    $sports = ['Cricket', 'FootBall', 'Tennis'];
    $form['favorite_sports'] = array(
      '#type' => 'select',
      '#title' => $this->t('Tell us your favorite sports.'),
      '#required' => TRUE,
      '#options' => array_combine($sports, $sports),
      
    );

      $form['favorite_player'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your favourite Men Player'),
      '#required' => TRUE,  
    );

      
      $womens = ['Mithali Raj', 'Sharapova', 'Sania Mirza','Marry Kom'];
      $form['favorite_women_player'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Your favourite Female Player'),
      '#required' => TRUE, 
      '#options' => array_combine($womens,$womens),
    );


    $form['comment'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Your Comment'),
    );


 $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  // foreach ($form_state->getValues() as $key => $value) {
  //     drupal_set_message($key . ': ' . $value);}

    // Save the data
   drupal_set_message($this->t('Thanks you for Submitting Form !'));
    $form_state->setRedirect('<front>');  
  }
}
