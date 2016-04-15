<?php
/**
 * Tagroups
 *
 * @copyright Copyright 2008-2015 ASHP/CML
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * The Tagroups controller class.
 *
 * @package Tagroups
 */
class Tagroups_TagroupsController extends Omeka_Controller_AbstractActionController {

  public function init() {
    $this->_helper->db->setDefaultModelName('Tagroup');
  }


  public function browseAction() {
    

    $db = get_db();
    $sql = "
SELECT 

`{$db->prefix}tagroups`.`id` AS `id`,
`{$db->prefix}tagroups`.`name`

FROM `{$db->prefix}tagroups` 

ORDER BY `{$db->prefix}tagroups`.`name`

    ";
    $result = $db->query($sql);
    $this->view->results = $result->fetchAll();
  }


  public function showAction () {

    if (is_numeric($this->_getParam('id'))) {
      $tagroup = get_record('Tagroup', array('id' => $this->_getParam('id')));
    } else {
      $this->addError('Tagroup', __('Invalid Tagroup id given.'));
    }
    $this->view->tagroup = $tagroup;

  }




  public function addAction() {

    $this->view->count = $this->_getcount();
    
    parent::addAction();
    
    
  }


  public function editAction() {

    $this->view->count = $this->_getcount();
    
    parent::editAction();
    
    
  }
  
  
  
  private function _getcount() {
  
    $db = get_db();
    $sql = "
SELECT 

COUNT(*) AS `count`

FROM `{$db->prefix}tagroups` 

    ";
    $result = $db->query($sql);
    $count = $result->fetchAll();
    return $count[0]['count'];
  
  }






  public function assignAction() {



    $this->_helper->db->setDefaultModelName('Tagroup_tags');
    $tagroups_table = $this->_helper->db->getTable('Tagroup_tags');
    if ($this->_request->isPost()) {
      $post = $this->_request->getPost();
      if (is_array($post['ids'])) {
        foreach ($post['ids'] as $id) {
          // Apply the updated values.
          if (($post['tagroups-tagroup_id-'.$id] != $post['tagroups-tagroup_id-original-value-'.$id])) {
            if (is_numeric($id)) {
              $tg = $tagroups_table->findById($id);
              $tg->tagroup_id = $post['tagroups-tagroup_id-'.$id];
              $tg->tag_id = $post['tagroups-tag_id-'.$id];
              $tg->save();
            } else {
              $tg = new TagroupTag();
              $tg->setPostData(array('tagroup_id' => $post['tagroups-tagroup_id-'.$id], 'tag_id' => $post['tagroups-tag_id-'.$id]));
              $tg->save(false);
            }
          }
        }
      }

      $this->_helper->flashMessenger(__('Tagroups successfully updated!'),'success');
    }

    $db = get_db();
    $result = $db->query("SELECT `{$db->prefix}tagroups`.`id` AS `id`, `{$db->prefix}tagroups`.`name` AS `name` FROM `{$db->prefix}tagroups` ORDER BY `{$db->prefix}tagroups`.`name`");
    $tagroups = array(0 => 'Unassigned');
    foreach ($result->fetchAll() as $name) {
      $tagroups[$name['id']] = $name['name'];
    }
    $this->view->tagroups = $tagroups;




    $result = $db->query(<<<SQL

SELECT 

CASE WHEN (`{$db->prefix}tagroup_tags`.`id` IS NOT NULL) THEN
  `{$db->prefix}tagroup_tags`.`id`
ELSE 
  MD5(`{$db->prefix}tags`.`name`)
END as `id`,

`{$db->prefix}tags`.`id` AS `tag_id`,
`{$db->prefix}tags`.`name` AS `name`,

CASE WHEN `{$db->prefix}tagroups`.`id` IS NOT NULL THEN
`{$db->prefix}tagroups`.`id` 
ELSE
'0'
END
AS `tagroup_id`,

CASE WHEN `{$db->prefix}tagroups`.`name` IS NOT NULL THEN
`{$db->prefix}tagroups`.`name` 
ELSE
'Undefined'
END
AS `tagroup_name`


FROM

`{$db->prefix}tags`

LEFT JOIN `{$db->prefix}tagroup_tags` ON `{$db->prefix}tags`.`id` = `{$db->prefix}tagroup_tags`.`tag_id`
LEFT JOIN `{$db->prefix}tagroups` ON `{$db->prefix}tagroups`.`id` = `{$db->prefix}tagroup_tags`.`tagroup_id`


ORDER BY `{$db->prefix}tagroups`.`name`, `{$db->prefix}tags`.`name`

SQL
);

    $this->view->records = $result->fetchAll();



  
  
  }
}
