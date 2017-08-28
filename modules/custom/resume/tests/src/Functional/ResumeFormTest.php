<?php
/**
 * @file
 * Contains \Drupal\Tests\resume\Functional\ResumeFormTest.
 */
namespace Drupal\Tests\resume\Functional;

use Drupal\Tests\BrowserTestBase;

/**
   * @coversDefaultClass \Drupal\resume\Form\ResumeForm
   * @group resume
   */


class ResumeFormTest extends BrowserTestBase {

  /**
   * Modules to install.
   * @var array
   */
  public static $modules = ['node','resume'];
  
  /**
   * Tests that 'resume/myform' returns a 200 OK response.
   */
  public function testResumeRouterURLIsAccessible() {
     $account = $this->drupalCreateUser(['administer permissions']);
    $this->drupalLogin($account);
    $this->drupalGet('resume/myform');
    $this->assertSession()->statusCodeEquals(200);
  }

public function testResumeFormSubmitButtonExists() {
    $this->drupalGet('resume/myform');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertNoFieldById('edit-submit');
  }
  /**
   * Test the submission of the form.
   * @throws \Exception
   */
  public function testResumeFormSubmit() {
    // submit the form with required fields
    $this->drupalPostForm(
      'resume/myform',
      array(
        'candidate_name' => 'Test',
        'candidate_mail' =>'test@gmail.com',
        'candidate_number' => '0123456789',
        'candidate_dob'=>'10-03-1992'
      ),
      t('Save')
    );
   
    $url='http://drupalhope.dd:8083/';
    $this->assertUrl($url);
    
    $this->assertText('Test Thanks for Submitng Form !');
  }

}