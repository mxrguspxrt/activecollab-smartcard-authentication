<?php

/* 
    @author mxrgus.pxrt 
    @version 2010 04 22
*/



  /**
   * IDCardUsers class
   * 
   * @package activeCollab.modules.system
   * @subpackage models
   */
  class IDCardUsers extends Users {

    /**
     * Return array of objects that match specific SQL
     *
     * @param string $sql
     * @param array $arguments
     * @param boolean $one
     * @return mixed
     */
    function findBySQL($sql, $arguments = null, $one = false) {
      return DataManager::findBySQL($sql, $arguments, $one, TABLE_PREFIX . 'users', 'IDCardUser');
    } // findBySQL

     /**
     * Return user by serial
     *
     * @param string $serial
     * @return User
     */
    function findBySerial($serial) {
      $serial = preg_replace("/[^\w\d]/", "", $serial);
      if(!$serial) {
        return false;
      }
      
      $sql  = "SELECT * FROM ".TABLE_PREFIX."user_config_options AS users_conf LEFT JOIN ".TABLE_PREFIX."users AS users ON users_conf.user_id=users.id WHERE name='im_value' AND value='s:11:\"".$serial."\";'";
    
      return self::findBySQL($sql, null, true);
    } // findByEmail    
  }

?>
