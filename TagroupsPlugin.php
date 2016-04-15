<?php
/**
 * Tagroups
 *
 * @copyright Copyright 2015 ASHP/CML
 * @license GPL
 */


/**
 * Tagroups plugin.
 */
 
if (!defined('TAGROUPS_PLUGIN_DIR')) {
  define('TAGROUPS_PLUGIN_DIR', dirname(__FILE__));
}

class TagroupsPlugin extends Omeka_Plugin_AbstractPlugin {
 /**
  * @var array Hooks and Filters for the plugin.
  */
  protected $_hooks = array('install', 'uninstall', 'upgrade', 'admin_head'); // 'define_routes', 

  protected $_filters = array('admin_navigation_main');

  /**
   * Install the plugin.
   */
  public function hookInstall() {

       $this->_db->query(<<<SQL

        CREATE TABLE IF NOT EXISTS {$this->_db->prefix}tagroups (
            id    int(10) unsigned NOT NULL auto_increment,
            name  tinytext collate utf8_unicode_ci NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SQL
);

        $this->_db->query(<<<SQL

        CREATE TABLE IF NOT EXISTS {$this->_db->prefix}tagroup_tags (
            id          int(10) unsigned NOT NULL auto_increment,
            tagroup_id	int(10) unsigned,
            tag_id      int(10) unsigned,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SQL
);



  }

    /**
     * Uninstall the plugin.
     */
    public function hookUninstall()
    {        
        $this->_db->query(<<<SQL
        DROP TABLE IF EXISTS {$this->_db->prefix}tagroups
SQL
);

        $this->_db->query(<<<SQL
        DROP TABLE IF EXISTS {$this->_db->prefix}tagroup_tags
SQL
);


    }

    /**
     * Upgrade the plugin.
     *
     * nothing to do
     */
    public function hookUpgrade($args) {
 
    }


    /**
     * Adds a navigation item
     */
  public function filterAdminNavigationMain($nav) {
    $nav[] = array(
      'label' => __('Tagroups'), 'uri' => url('tagroups/tagroups/browse')
    );
    return $nav;
  }




  /**
   * Admin Head
   */
  public function hookAdminHead() {        
    $tags = array();
    if (is_array($tg = get_records('Tag',array('sort_field' => 'name', 'sort_dir' => 'a',),15000))) {
      foreach ($tg as $t) {
        $tags[] = $t->name;
      }
    }
    $itemTags = array();
    if (get_current_record('item', false) && metadata('item','has tags')){
      $itemTags = explode(',', tag_string('Item',null,','));
    }

    queue_js_file('tagroups');
    queue_js_string('var tagList = '.json_encode($tags).';var itemTags = '.json_encode($itemTags).';');
    
    
    $result = $this->_db->query(<<<SQL

SELECT 

`{$this->_db->prefix}tags`.`name` AS `name`,
`{$this->_db->prefix}tagroups`.`name` AS `tagroup`

FROM

`{$this->_db->prefix}tagroup_tags`

INNER JOIN `{$this->_db->prefix}tags` ON `{$this->_db->prefix}tags`.`id` = `{$this->_db->prefix}tagroup_tags`.`tag_id`
INNER JOIN `{$this->_db->prefix}tagroups` ON `{$this->_db->prefix}tagroups`.`id` = `{$this->_db->prefix}tagroup_tags`.`tagroup_id`

WHERE 

`{$this->_db->prefix}tagroups`.`name` != 'Undefined'

ORDER BY
`{$this->_db->prefix}tagroups`.`name`, `{$this->_db->prefix}tags`.`name`

SQL
);
    $organizedTags = array();
    if ($rec = $result->fetchAll()) {
      foreach ($rec as $r) {
        $organizedTags[$r['tagroup']][] = $r['name'];
      }
    }

    queue_js_string('var organizedTags = '.json_encode($organizedTags).';');



  }


}