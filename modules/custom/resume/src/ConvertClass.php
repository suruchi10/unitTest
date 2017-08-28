<?php
 
/**
 * @file
 * Contains \Drupal\resume\ConvertClass.
 */
 
namespace Drupal\resume;
 
/**
 * Provide functions for converting measurements.
 *
 * @package Drupal\resume.
 */
class ConvertClass {
 
  /**
   * Convert Celsius to Fahrenheit
   *
   * @param $temp
   *
   * @return int
   */
 public function celsiusToFahrenheit($temp) {
    return ($temp * (9/5)) + 32;
  }
}