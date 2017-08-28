<?php
/**
 * @file
 * Contains \Drupal\mockingdrupal\Form\MockingDrupalForm.
 */
namespace Drupal\mockingdrupal\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MockingDrupalForm extends FormBase {
  /**
   * {@inheritdoc}
   */

    public function getFormId() {
     return 'mockingdrupal_form';
    }

   public function buildForm(array $form, FormStateInterface $form_state) {

    $form['node_id'] = [
   '#type' => 'number',
   '#title' => $this->t('Node id'),
   '#description' => $this->t('Provide a node id.'),
   '#min' => 1,
   '#required' => TRUE,
   ];

   $form['actions']['#type'] = 'actions';
     $form['actions']['submit'] = array(
     '#type' => 'submit',
     '#value' => $this->t('Display'),
     '#button_type' => 'primary',
      );
     if ($form_state->getValue('node_id', 0)) {
         try {
         $node = $this->entityManager->getStorage('node')->load($form_state->getValue('node_id',0));

         if (!isset($node)) {
         throw new \Exception;
         }
         $form['node'] = [
         '#type' => 'label',
         '#label' => $node->getTitle(),
         ];
         }
         catch (\Exception $e) {
         $this->logger->error('Could not load node id: %id', ['%id' => $form_state->getValue('node_id', 0)]);
         }
       }
    return $form;
  }

  	public function validateForm(array &$form, FormStateInterface $form_state) {
      if (strlen($form_state->getValue('node_id')) < 3) {
        $form_state->setErrorByName('node_id', $this->t('three digit number'));
      }
     }


    public function submitForm(array &$form,FormStateInterface $form_state) {   
       $form_state->setRedirect('<front>');   
   }
}
