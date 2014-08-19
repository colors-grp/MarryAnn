<?php 
session_start();
 
require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );
require_once( 'Facebook/GraphSessionInfo.php' );
 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
 
$appid = '170161316509571'; // your AppID
$secret = '92fcf6d4ac1dc115b01755afaacd4f9f'; // your secret
 
// Initialize app with app id (APPID) and secret (SECRET)
FacebookSession::setDefaultApplication($appid ,$secret);
 
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper( 'http://www.hitseven.net/SS/fbtest/' );
 
try
{
  // In case it comes from a redirect login helper
  $session = $helper->getSessionFromRedirect();
  
  if($_GET["code"]) {

  try {

    // Upload to a user's profile. The photo will be in the
    // first album in the profile. You can also upload to
    // a specific album by using /ALBUM_ID as the path     
    $response = (new FacebookRequest(
      $session, 'POST', '/me/photos', array(
        'source' => new CURLFile('goofy-2.png', 'image/png'),
        'message' => 'User provided message'
      )
    ))->execute()->getGraphObject();

    // If you're not using PHP 5.5 or later, change the file reference to:
    // 'source' => '@/path/to/file.name'

    echo "Posted with id: " . $response->getProperty('id');

  } catch(FacebookRequestException $e) {

    echo "Exception occured, code: " . $e->getCode();
    echo " with message: " . $e->getMessage();

  }   

}
  
} 
catch( FacebookRequestException $ex ) 
{
  // When Facebook returns an error
  echo $ex;
} 
catch( Exception $ex ) 
{
  // When validation fails or other local issues
  echo $ex;
}
 
// see if we have a session in $_Session[]
if( isset($_SESSION['token']))
{
    // We have a token, is it valid? 
    $session = new FacebookSession($_SESSION['token']); 
    try
    {
        $session->Validate($appid ,$secret);
    }
    catch( FacebookAuthorizationException $ex)
    {
        // Session is not valid any more, get a new one.
        $session ='';
    }
}
 
// see if we have a session
if ( isset( $session ) ) 
{   
    // set the PHP Session 'token' to the current session token
    $_SESSION['token'] = $session->getToken();
    // SessionInfo 
    $info = $session->getSessionInfo();  
    // getAppId
    echo "Appid: " . $info->getAppId() . "<br />"; 
    // session expire data
    $expireDate = $info->getExpiresAt()->format('2014-06-14 12:00:00');
    echo 'Session expire time: ' . $expireDate . "<br />"; 
    // session token
    echo 'Session Token: ' . $session->getToken() . "<br />";

} 
else
{
  // show login url
  echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
}
?>