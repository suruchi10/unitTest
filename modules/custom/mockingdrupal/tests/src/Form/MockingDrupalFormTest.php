<?php
 /**
 * @file
 * Contains \Drupal\Tests\mockingdrupal\Form\MockingDrupaLFormTest.
 */
namespace Drupal\Tests\mockingdrupal\Form;
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
   * @coversDefaultClass \Drupal\mockingdrupal\Form\mockingDrupalForm
   * @group MockingDrupalFrom
   */

class MockingDrupalFormTest extends UnitTestCase {
        
  protected $formBuilder;

 
  protected $translationManager;
  protected $logger;
  protected $form;
 



protected function setUp() {
    parent::setUp();
 
	 	$this->node_title = $this->getRandomGenerator()->word(10);
		$this->node = $this->getMockBuilder('Drupal\node\Entity\Node')
		 ->disableOriginalConstructor()
		 ->getMock();
		$this->node->expects($this->any())
		 ->method('getTitle')
		 ->will($this->returnValue($this->node_title));
		$this->nodeStorage = $this->getMockBuilder('Drupal\node\NodeStorage')
		 ->disableOriginalConstructor()
		 ->getMock();

		$this->nodeStorage->expects($this->any())
		 ->method('load')
		 ->will($this->returnValueMap([
		 [1, $this->node],
		 [500, NULL],
		 ]));

		$entityManager = $this->getMockBuilder('Drupal\Core\Entity\EntityManagerInterface')
		 ->disableOriginalConstructor()
		 ->getMock();
		$entityManager->expects($this->any())
		 ->method('getStorage')
		 ->with('node')
		 ->willReturn($this->nodeStorage); 

 		$loggerFactory = $this->getMockBuilder('Drupal\Core\Logger\LoggerChannelFactoryInterface')
 		->getMock();
 		
		
		$stringTranslation = $this->getMockBuilder('Drupal\Core\StringTranslation\TranslationInterface')
 		->disableOriginalConstructor()
		 ->getMock();
		

       
		$container = new ContainerBuilder();
		$container->set('entity.manager', $entityManager);
		$container->set('logger.factory', $loggerFactory );
		$container->set('string_translation',$stringTranslation);
		\Drupal::setContainer($container);
		 // Instantiatie the form class.
		
		
		
    }
	 
    public function testGetFormID() {
    	// public $form;
    	$form1 = $this->getMockBuilder(MockingDrupalForm::class)
	 	 ->setMethods(['getFormId'])
	 	 ->getMock();
	 	 
		 $form1->expects($this->once())
                 ->method('getFormId')
                 ->willReturn('mockingdrupal_form');

		 $this->assertEquals('mockingdrupal_form',  $form1->getFormId());

    }
     public function testBuildForm() {

  		 $state = new FormState();
		 $state->setValue('node_id', 1);

     	$form2= $this->getMockBuilder(MockingDrupalForm::class)
	 	 ->setMethods(['buildForm'])
	 	 ->getMock();
	 	 
		$form2->expects($this->once())
                 ->method('buildForm')
                 ->with($form2, $state)
                 ->willReturn($form2);

		  $this->assertEquals($this->node_title, $form2->buildForm());
 }


public function testBuildForm2() {
$this->formBuilder = $this->getMock('Symfony\Component\Form\Tests\FormBuilderInterface');
$this->form =$this->getMock('Drupal\mockingdrupal\Form\MockingDrupalForm');
 $form3= $this->formBuilder->getForm($this->form);
 $this->assertEquals('mockingdrupal_form', $form3['#form_id']);
 $state = new FormState();
 $state->setValue('node_id', 1);
 // Fresh build of form with no form state for a value that exists.
 $form4 = $this->formBuilder->buildForm($this->form, $state);
 $this->assertEquals($this->node_title, $form4['node']['#label']);
 // Build the form with a mocked form state that has value for node_id that
 // does not exist i.e. exception testing.
 // $state2 = new FormState();
 // $state2->setValue('node_id', 500);
 // $form5 = $this->formBuilder->buildForm($this->form, $state2);
 // $this->assertArrayNotHasKey('node', $form5);
 } 

	
}