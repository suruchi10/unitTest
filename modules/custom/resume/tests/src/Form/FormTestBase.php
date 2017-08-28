 <?php

namespace Drupal\Tests\resume\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Url;


/**
 * Provides a base class for testing form functionality.
 *
 * @see \Drupal\resume\Form\ResumeForm
 */
abstract class FormTestBase extends UnitTestCase {
/**
   * The form builder being tested.
   *
   * @var \Drupal\resume\Form\ResumeForm
   */
  protected $formBuilder;



  /**
   * The CSRF token generator.
   *
   * @var \Drupal\Core\Access\CsrfTokenGenerator|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $csrfToken;

  /**
   * The request.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The class results.
   *
   * @var \Drupal\Core\DependencyInjection\ClassResolverInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $classResolver;

  /**
   * The element info manager.
   *
   * @var \Drupal\Core\Render\ElementInfoManagerInterface
   */
  protected $elementInfo;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $eventDispatcher;

  /**
   * @var \Drupal\Core\StringTranslation\TranslationInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $translationManager;

 

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject|\Psr\Log\LoggerInterface
   */
  protected $logger;
  protected $formBase;
  protected $formInterface;
  protected $formStateInterface;
  protected $response ;


  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Add functions to the global namespace for testing.
   // require_once __DIR__ . '/fixtures/form_base_test.inc';


    $this->moduleHandler = $this->getMock('Drupal\Core\Extension\ModuleHandlerInterface');

  
    $this->classResolver = $this->getClassResolverStub();

    $this->elementInfo = $this->getMockBuilder('\Drupal\Core\Render\ElementInfoManagerInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $this->elementInfo->expects($this->any())
      ->method('getInfo')
      ->will($this->returnCallback([$this, 'getInfo']));

    $this->csrfToken = $this->getMockBuilder('Drupal\Core\Access\CsrfTokenGenerator')
      ->disableOriginalConstructor()
      ->getMock();
  
    $this->request = new Request();
    $this->eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
    $this->requestStack = new RequestStack();
    $this->requestStack->push($this->request);
    $this->logger = $this->getMock('Drupal\Core\Logger\LoggerChannelInterface');
    $this->formBase = $this->getMock('\Drupal\Core\Form\FormBase');
    $this->formInterface = $this->getMock('\Drupal\Core\Form\FormInterface');
    $this->formStateInterface = $this->getMock('\Drupal\Core\Form\FormStateInterface');
    $this->$response = $this->getMockBuilder('Symfony\Component\HttpFoundation\Response')
      ->disableOriginalConstructor()
      ->getMock();

   

   

    $this->formBuilder = new FormBuilder( $this->formBase,$this->formInterface,$this->formStateInterface $this->moduleHandler, $this->eventDispatcher, $this->requestStack, $this->classResolver, $this->elementInfo, $this->csrfToken);
  }

  /**
   * {@inheritdoc}
   */

  protected function tearDown() {
    Html::resetSeenIds();
    (new FormState())->clearErrors();
  }
  
  protected function getMockForm($form_id, $expected_form = NULL, $count = 1) {
    $form = $this->getMock('Drupal\resume\Form\ResumeForm');
    $form->expects($this->once())
      ->method('getFormId')
      ->will($this->returnValue($form_id));

    if ($expected_form) {
      $form->expects($this->exactly($count))
        ->method('buildForm')
        ->will($this->returnValue($expected_form));
    }
    return $form;
  }

  
  protected function simulateFormSubmission($form_id, FormInterface $form_arg, FormStateInterface $form_state, $programmed = TRUE) {
    $input = $form_state->getUserInput();
    $input['op'] = 'Submit';
    $form_state
      ->setUserInput($input)
      ->setProgrammed($programmed)
      ->setSubmitted();
    return $this->formBuilder->buildForm($form_arg, $form_state);
  }

 

}