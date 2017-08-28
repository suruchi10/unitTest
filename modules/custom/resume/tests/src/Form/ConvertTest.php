<?php

/**
 * @file
 * Contains \Drupal\Tests\resume\Unit\ConvertTest.
 */
namespace Drupal\Tests\resume\Unit;
use Drupal\Tests\UnitTestCase;

/**
   * @coversDefaultClass \Drupal\resume\ConvertClass
   * @group resumeUnit
   * Modules to enable.
   *  @var array
   */

 class ConvertTest extends UnitTestCase {
 
  /**
   * @var \Drupal\resume\ConvertTest
   */
  public $conversionService;
 
  public function setUp() {
    $this->conversionService = new \Drupal\resume\ConvertClass();
  }
 
  /**
   * A simple test that tests our celsiusToFahrenheit() function.
   */
  public function testOneConversion() {
    // Confirm that 0C = 32F.
    $this->assertEquals(32, $this->conversionService->celsiusToFahrenheit(0));
  }
  public function testTwoConversion() {
    // Confirm that 45C = 113F.
    $this->assertEquals(113, $this->conversionService->celsiusToFahrenheit(45));
  }
  public function testThreeConversion() {
    // Confirm that 20C=68F
    $this->assertEquals(68, $this->conversionService->celsiusToFahrenheit(20));
  }
  public function testFourConversion() {
    // Confirm that 20C=68F(fails)
    $this->assertEquals(68, $this->conversionService->celsiusToFahrenheit(40));
  }
 
//Unit test is working fine in jenkins for push event

 
}