<?php

/**
 * @package     omeka
 * @subpackage  Tagroups
 * @copyright   2015 ASHP/CML
 * @license     GPL
 */


class Tagroup extends Omeka_Record_AbstractRecord {

  /**
   * The title of the element.
   **/
  public $name;

  public function __construct($element=null) {
    parent::__construct();
  }



  protected function _validate() {        
    if (empty($this->name)) {
      $this->addError('name', __('The Tagroup must be given a title.'));
    }        
                
    if (!$this->fieldIsUnique('name')) {
      $this->addError('name', __('The name is already in use. Please choose another.'));
    }
  }


}
