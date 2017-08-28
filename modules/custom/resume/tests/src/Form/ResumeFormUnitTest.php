<?php
 /**
 * @file
 * Contains \Drupal\Tests\resume\Form\ResumeFormUnitTest.
 */
namespace Drupal\Tests\resume\Form;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\Url;


/**
   * @coversDefaultClass \Drupal\resume\Form\ResumeForm
   * @group ResumeForm
   */

class ResumeFormUnitTest extends UnitTestCase {

/**
   * The form builder being tested.
   *
   * @var \Drupal\resume\Form\ResumeForm
   */
  protected $formBuilder;

  protected $formValidator; 
  protected $formSubmitter;

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


 /**
   * The dependency injection container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerBuilder
   */
protected $container;

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
   $this->themeManager = $this->getMock('Drupal\Core\Theme\ThemeManagerInterface');
    $this->request = new Request();
    $this->eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
    $this->requestStack = new RequestStack();
    $this->requestStack->push($this->request);
    $this->formCache = $this->getMock('Drupal\Core\Form\FormCacheInterface');
    $this->logger = $this->getMock('Drupal\Core\Logger\LoggerChannelInterface');
    $this->formBase = $this->getMock('\Drupal\Core\Form\FormBase');
    $this->formInterface = $this->getMock('\Drupal\Core\Form\FormInterface');
    $this->formStateInterface = $this->getMock('\Drupal\Core\Form\FormStateInterface');
    $this->response = $this->getMockBuilder('Symfony\Component\HttpFoundation\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $form_error_handler = $this->getMock('Drupal\Core\Form\FormErrorHandlerInterface');
    $this->formValidator = $this->getMockBuilder('Drupal\Core\Form\FormValidator')
      ->setConstructorArgs([$this->requestStack, $this->getStringTranslationStub(), $this->csrfToken, $this->logger, $form_error_handler])
      ->setMethods(NULL)
      ->getMock();
    $this->urlGenerator = $this->getMock('Drupal\Core\Routing\UrlGeneratorInterface');

    $this->formSubmitter = $this->getMockBuilder('Drupal\Core\Form\FormSubmitter')
      ->setConstructorArgs([$this->requestStack, $this->urlGenerator])
      ->setMethods(['batchGet', 'drupalInstallationAttempted'])
      ->getMock();

    $this->formBuilder= new FormBuilder($this->formValidator, $this->formSubmitter, $this->formCache,  $this->moduleHandler, $this->eventDispatcher, $this->requestStack, $this->classResolver, $this->elementInfo,$this->themeManager, $this->csrfToken);


    $form =getMockBuilder('Drupal\resume\Form\ResumeForm');

    $this->container = new ContainerBuilder();
   $container->set('logger.factory', $logger);
    \Drupal::setContainer($this->container);
    $this->form = ResumeForm::create($container); 
  }

  /**
   * Tests the getFormId() method with a string based form ID.
   */
 
public function testGetFormIdWithString() {
    $form_arg = 'foo';
    $form_state = new FormState();
    $this->setExpectedException(\InvalidArgumentException::class, 'The form argument foo is not a valid form.');
    $this->formBuilder->getForm($this->form)->getFormId($form_arg, $form_state);
  }

  public function testGetFormId() {
    $this->$form = $this->formBuilder->getForm($this->form);
    $this->assertEquals('resume_form', $form['#form_id']); 
    
  }
}