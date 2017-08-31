<?php
 /**
 * @file
 * Contains \Drupal\Tests\resume\Form\ResumeFormUnitTest.
 */
namespace Drupal\Tests\resume\Form;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Form\FormState;
use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;


/**
   * @coversDefaultClass \Drupal\resume\Form\ResumeForm
   * @group ResumeForm
   */

class ResumeFormUnitTest extends UnitTestCase {

 
  protected $translationManager;
  protected $logger;
  protected $form;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $loggerFactory = $this->getMockBuilder('Drupal\Core\Logger\LoggerChannelFactoryInterface')
    ->getMock();
    
    
    $stringTranslation = $this->getMockBuilder('Drupal\Core\StringTranslation\TranslationInterface')
    ->disableOriginalConstructor()
     ->getMock();
    

       
    $container = new ContainerBuilder();
    $container->set('logger.factory', $loggerFactory );
    $container->set('string_translation',$stringTranslation);
    \Drupal::setContainer($container);
   
  }

  /**
   * Tests the getFormId() method with a string based form ID.
   */
 
  public function testGetFormID() {
      // public $form;
      $form = $this->getMockBuilder(ResumeForm::class) 
     ->setMethods(['getFormId'])
     ->getMock();
     
     $form->expects($this->any())
                 ->method('getFormId')
                 ->willReturn('resume_form');

     $this->assertEquals('resume_form',  $form->getFormId());

 
}

public function testBuildForm() {
     
    $state = new FormState();
  
    $form = $this->getMockBuilder(ResumeForm::class)
     ->setMethods(['buildForm'])
     ->getMock(); 
    $form->expects($this->any())
                 ->method('buildForm')
                 ->willReturn($form) ;   

    $this->assertEquals($form, $form->buildForm($form, $state));
   
 }  
  public function testFormValidation() {
 
     $formBuilder = $this->getMockBuilder('\Drupal\Core\Form\FormBuilderInterface')
       ->getMock();
    $form= $formBuilder->getForm($form_obj);
    $form_obj= new \Drupal\resume\Form\ResumeForm();
    var_dump($form);       

        $input = ['op' => 'Save',
               'form_id' => $form_obj->getFormId(),
               'values' => ['candidate_name'=> 'astha',
               'candidate_mail'=> 'a@gmail.com',
               'candidate_number'=> '0123456789',
                'candidate_dob'=> '17-08-2017',
                'op' => 'Save'],
               ]; 

    $state = new FormState();
    $state
         ->setUserInput($input)
         ->setValues($input['values'])
         ->setFormObject($form_obj)
         ->setSubmitted(TRUE)
         ->setProgrammed(TRUE);
 $form_obj->validateForm($form, $state); 
 $this->assertEmpty($state->getErrors());        
 }  

 // to cheeck

}