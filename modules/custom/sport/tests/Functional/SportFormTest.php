<?php
/**
 * @file
 * Contains \Drupal\Tests\sport\Functional\SportFormTest.
 */

namespace Drupal\Tests\sport\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * @coversDefaultClass \Drupal\sport\Form\SportForm
 * @group SPORT
 */
class SportFormTest extends BrowserTestBase {

  /**
   * Modules to install.
   * @var array
   */
  public static $modules = ['node', 'sport'];


  /**
   * Tests that 'sport/form' returns a 200 OK response.
   */

    public function testSportRouterURLIsAccessible() {
      $account = $this->drupalCreateUser(['administer permissions']);
    $this->drupalLogin($account);
      $this->drupalGet('sport/form');
      $code=$this->assertSession()->statusCodeEquals(200);
      
    }

  /**
   * Tests that the form has a submit button to use.
   */
    public function testSportFormSubmitButtonExists() {
      $this->drupalGet('sport/form');
      $this->assertResponse(200);
      $this->assertNoFieldById('edit-submit');
    }

  /**
   * Test to verify both radio  button is present
   */
  public function testSportFormRadioButtonValuesExist() {
    $this->drupalGet('sport/form');
    $this->assertResponse(200);

    //check that our select field displays on the form
    $this->assertNoFieldById('edit-game'); 
  }

  /**
   * Test to verify all the elements present in dropdown
   */
  public function testSportFormDropDownValuesExist() {
    $this->drupalGet('sport/form');
    $this->assertResponse(200);

    // check that our select field displays on the form
    $this->assertFieldByName('favorite_sports');

    // check that all of our options are available
    $sports = ['Cricket', 'FootBall', 'Tennis'];

    foreach ($sports as $sport) {
      $this->assertOption('edit-favorite-sports', $sport);

    }

    // check that Soccer is not an option. Sorry, Soccer lovers.
    $this->assertNoOption('edit-favorite-sports', 'Soccer');
  }

  /**
   * Test to verify all the elements present in checkboxes
   */
  public function testSportFormCheckBoxValuesExist() {
    $this->drupalGet('sport/form');
    $this->assertResponse(200);

    // check that our CheckBox has all options
    $this->assertNoFieldById('edit-favorite-women-player');

    // check that all of our options are available

    $this->assertNoFieldChecked('edit-favorite-women-player-mithali-raj');
    $this->assertNoFieldChecked('edit-favorite-women-player-sharapova');
    $this->assertNoFieldChecked('edit-favorite-women-player-sania-mirza');
    $this->assertNoFieldChecked('edit-favorite-women-player-marry-kom');
  }



  /**
   * Test the submission of the form.
   * @throws \Exception
   */
  public function testSportFormSubmit() {
    // submit the form with  all required value
    
    $edit['favorite_women_player[Mithali Raj]'] ='Sharapova';
    $edit['favorite_sports']='FootBall';
    $edit['favorite_player' ]='Messi';
    $edit['comment']='Love';
    $this->drupalPostForm(
      'sport/form',$edit,
      t('Submit')
    ); 

    $url='http://drupalhope.dd:8083/';
    $this->assertUrl($url);
    
    $this->assertText('Thanks you for Submitting Form !');
  }
}