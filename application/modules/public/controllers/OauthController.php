<?php
/**
 * CloneUI.com - CloneUI.com Base Framework
 * OAuth Controller
 *
 * @author      CloneUI <hire@bizlogicdev.com>
 * @copyright   2014 CloneUI
 * @link        http://bizlogicdev.com
 * @license     Commercial
 *
 * @since  	    Friday, June 27, 2014, 03:38 AM GMT+1
 * @modified    $Date: 2014-06-14 09:21:49 -0700 (Sat, 14 Jun 2014) $ $Author: hire@bizlogicdev.com $
 * @version     $Id: IndexController.php 56 2014-06-14 16:21:49Z hire@bizlogicdev.com $
 *
 * @category    Controllers
 * @package     CloneUI.com Base Framework
*/

class OauthController extends Zend_Controller_Action
{	
	protected $_headers;
	
    public function init() 
    {  	
    	$this->_headers = get_all_headers();
    }

    public function indexAction() 
    {
    	$this->_helper->viewRenderer->setNoRender( true );
		$this->getResponse()->setHttpResponseCode( 404 );
		throw new Zend_Controller_Action_Exception('This page does not exist', 404);
    }
    
    /**
     * Authorization Endpoint
     * 
     * @return void
    */
    public function authAction()
    {
    	$error = array();
    	
    	$CloneUI_Oauth_Apps = new CloneUI_Oauth_Apps;
    	$app = $CloneUI_Oauth_Apps->getBy( $_GET['client_id'], 'uuid' );
    	
    	if( empty( $app ) ) {
    		$error[] = 'Invalid Client ID';    		
    	} else {
    		$this->view->app = $app;	
    	}
    	
    	$required = array(
    		'access_type',
    		'client_id',
    		'redirect_uri',
    		'response_type',    			  				
    		'scope',
    	);

    	$diff = array_diff( $required, array_keys( $_GET ) );
    	if( !empty( $diff ) ) {
    		$error = array_merge( $error, $diff );	
    	} else {
    		// check credentials	
    	}
    	
    	$this->view->error = $error;
    }    
    
    /**
     * Token Endpoint
     *
     * @return void
    */    
    public function tokenAction() 
    {
    	$this->_helper->viewRenderer->setNoRender( true );
    	header('Content-Type: application/json');
    	
    	if( !empty( $_POST ) ) {
    		$method = $_POST['method'];
    		switch( $method ) {
    			default:
    				$reponse['status']	= 'ERROR';
    				$reponse['error']	= 'UNHANDLED_EXCEPTION';    			
    		}
    	} else {
    		$reponse['status']	= 'error';
    		$reponse['error']	= 'Not a POST request';    		
    	}	
    			
    	exit( json_encode( $reponse ) );  		    	
    }
    
    /**
     * Request Endpoint
     *
     * @return void
    */    
    public function requestAction() {}
}