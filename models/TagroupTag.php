<?php

/**
 * @package     omeka
 * @subpackage  Tagroups
 * @copyright   2015 ASHP/CML
 * @license     GPL
 */


class TagroupTag extends Omeka_Record_AbstractRecord {

  /**
   * The tagroup id
   **/
  public $tagroup_id;


  /**
   * The tag id
   **/
  public $tag_id;


  public function __construct($element=null) {
    parent::__construct();
  }

  public function findById($id) {
    return $this->findBySql('id=?', array($id), true);
  }

}
