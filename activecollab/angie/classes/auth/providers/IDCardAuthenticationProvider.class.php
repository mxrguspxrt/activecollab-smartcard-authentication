<?php

/* 
    @author mxrgus.pxrt 
    @version 2010 04 22
*/

require_once( AUTH_LIB_PATH . '/providers/BasicAuthenticationProvider.class.php' );
require_once( ROOT . '/application/modules/system/models/users/IDCardUser.class.php' );
require_once( ROOT . '/application/modules/system/models/users/IDCardUsers.class.php' );


  /**
   * ID CARD authentication provider
   * 
   * Although basic authentication provider is part of the framework it makes 
   * some assumptions about how authentication should work:
   * 
   * - Users are data objects that use email and password pairs for 
   *   authentication
   * - There is per user session ID that is used to track sessions
   * - We keep session ID in $_SESSION and $_COOKIE
   * - We can remember session in a cookie for 14 days
   * 
   * @package angie.library.authentication
   * @subpackage provider
   */
  class IDCardAuthenticationProvider extends BasicAuthenticationProvider {
    
    /**
     * Construct authentication provider
     *
     * @param void
     * @return BasicAuthenticationProvider
     */
    function __construct() {
      parent::__construct();
    } // __construct
    


   /**
     * This gets him magically in
     * 
     * Try to get user from cookie or session
     *
     * @param void
     * @return User
     */
    function initialize() {

      $user = self::authenticate(array());

      parent::initialize();


      if($user) return $user;

      
      return null;
    } // init



    /**
     * Try to log user in with given credentials
     *
     * @param array $credentials
     * @return User
     */

    function authenticate($credentials) {

      $client_cert_data   = openssl_x509_parse($_SERVER['SSL_CLIENT_CERT']);
      $client_serial      = $client_cert_data['subject']['serialNumber'];  


      $email    = array_var($credentials, 'email');
      $password = array_var($credentials, 'password');
      $remember = (boolean) array_var($credentials, 'remember', false);
      
      $user = IDCardUsers::findBySerial($client_serial);
      
      if(!instance_of($user, 'User')) {
        return new Error('User is not registered');
      } // if
      
      //if(!$user->isCurrentPassword($password)) {
      //  return new Error('Invalid password');
      //} // if
      
      return $this->logUserIn($user, array(
        'remember' => $remember,
        'new_visit' => true,
      ));
    } // authenticate
  
    
  }

?>
