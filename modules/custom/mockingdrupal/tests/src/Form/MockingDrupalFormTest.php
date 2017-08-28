<?php
 /**
 * @file
 * Contains \Drupal\Tests\mockingdrupal\Form\MockingDrupaLFormTest.
 */
namespace Drupal\Tests\mockingdrupal\Form;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\mockingdrupal\Form;

/**
   * @coversDefaultClass \Drupal\mockingdrupal\Form\mockingDrupalForm
   * @group MockingDrupalFrom
   * Modules to enable.
   *  @var array
   */

class MockingDrupalFormTest extends UnitTestCase {

 
	 protected function setUp() {
        // Set the container into the Drupal object so that Drupal can call the
	    // mocked services.
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
 		->disableOriginalConstructor()
		 ->getMock();
		//$loggerFactory->expects($this->any());
		$stringTranslation = $this->getMockBuilder('Drupal\Core\StringTranslation\TranslationInterface')
 		->disableOriginalConstructor()
		 ->getMock();	

		$container = new ContainerBuilder();
		$container->set('entity.manager', $entityManager);
		$container->set('logger.factory', $loggerFactory);
		$container->set('string_translation',$stringTranslation);
		\Drupal::setContainer($container);
		 // Instantiatie the form class.
	    $this->form = new MockingDrupalForm();
	    $this->form->create($container);
    }
	 


	 public function testBuildForm() {

	 	 
		 $form = $this->formBuilder->getForm($this->form);
		 $this->assertEquals('mockingdrupal_form', $form['#form_id']);
		 $state = new FormState();
		 $state->setValue('node_id', 1);
		 // Fresh build of form with no form state for a value that exists.
		 $form = $this->formBuilder->buildForm($this->form, $state);
		 $this->assertEquals($this->node_title, $form['node']['#label']);
		 // Build the form with a mocked form state that has value for node_id that
		 // does not exist i.e. exception testing.
		 $state = new FormState();
		 $state->setValue('node_id', 100);
		 $form = $this->formBuilder->buildForm($this->form, $state);
		 $this->assertArrayNotHasKey('node', $form);
	 } 


	 public function testFormValidation() {

		 $form = $this->formBuilder->getForm($this->form);
		 $input = [
		 'op' => 'Display',
		 'form_id' => $this->form->getFormId(),
		 'form_build_id' => $form['#build_id'],
		 'values' => ['node_id' => 100, 'op' => 'Display'],
		 ];
		 $state = new FormState();
		 $state
		 ->setUserInput($input)
		 ->setValues($input['values'])
		 ->setFormObject($this->form)
		 ->setSubmitted(TRUE)
		 ->setProgrammed(TRUE);
		 $this->form->validateForm($form, $state);
		 $errors = $state->getErrors();
		 $this->assertArrayHasKey('node_id', $errors);

		 $this->assertEquals('Node does not exist.',
		\PHPUnit_Framework_Assert::readAttribute($errors['node_id'], 'string'));
		 
		 $input['values']['node_id'] = 1;
		 $state = new FormState();
		 $state
		 ->setUserInput($input)
		 ->setValues($input['values'])
		 ->setFormObject($this->form)
		 ->setSubmitted(TRUE)
		 ->setProgrammed(TRUE);
		 $this->form->validateForm($form, $state);
		 $this->assertEmpty($state->getErrors());
    }
}