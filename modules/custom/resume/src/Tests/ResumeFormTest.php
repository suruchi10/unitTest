<?php
/**
 * @file
 * Contains \Drupal\resume\Tests\ResumeFormTest.
 */

namespace Drupal\resume\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provide some basic tests for our ResumeForm form.
 * @group RESUME
 */
class ResumeFormTest extends WebTestBase {

  /**
   * Modules to install.
   * @var array
   */
  public static $modules = ['node', 'resume'];

  /**
   * Tests that 'resume/myform' returns a 200 OK response.
   */
  public function testResumRouterURLIsAccessible() {
    $this->drupalGet('resume/myform');
    $this->assertResponse(200);
  }



  /**
   * Tests that the form has a submit button to use.
   */
  public function testResumeFormSubmitButtonExists() {
    $this->drupalGet('resume/myform');
    $this->assertResponse(200);
    $this->assertFieldById('edit-submit');
  }


   /**
   * Tests that the form has a reuired fields with that.
   */
  public function testResumeFormCNameExists() {
    $this->drupalGet('resume/myform');
    $this->assertResponse(200);
    $this->assertNoFieldByName('candidate_name');
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
        'candidate_name' => 'Blueberry',
        'candidate_mail' =>'test@gmail.com',
        'candidate_number' => '0123456789',
        'candidate_dob'=>'10-03-1992',
      ),
      t('Save')
    );

    // we should now be on the homepage, and see the right form success message
    $this->assertUrl('<front>');
    $this->assertText('Blueberry Thanks for Submitng Form !', 'The successful submission message was detected on the screen.');


  }
}