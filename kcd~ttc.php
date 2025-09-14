<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('UTC'); 

$LoginDialog      = true;
$login_user       = '';
$login_pass       = 'ninteachan';
$charset          = 'utf-8';
$show_file_or_dir = true ; // can show directory
$perpage          = (isset($_GET['perpage'])) ? (int)$_GET['perpage'] : 10;
$table_fixed      = (isset($_GET['perpage'])) ? 'table-fixed' : '';
$alert_msg        = (isset($_GET['alert'])) ? $_GET['alert'] : '';


@session_start();
if(isset($_GET['logout'])) { session_destroy() ; exit(header('Location: '.$_SERVER['PHP_SELF'])); }

 if(isset($_POST['username']) && isset($_POST['password']) )
 {
	if($_POST['username'] == $login_user && $_POST['password'] == $login_pass) 
	{
		
		$_SESSION['login']['user'] = $login_user ;
		$_SESSION['login']['pass'] = $login_pass ;
		$_SESSION['login']['status'] = "1" ;
		exit(header('Location: '.$_SERVER['PHP_SELF'] ));
	}
		
 }

$_extensions[0]  = array();
$_extensions[1]  = array();
//$_extensions[1] = array( "css","js","txt","json","xml"); // can read _extensions
//$_extensions[0] = array("gif", "jpg", "jpeg", "png","bmp","dir","css","js");  // Allowed_extensions = in Browse directorie

$RTL_languages  = array('ar','arc','bcc','bqi','ckb','dv','fa','glk','he','lrc','mzn','pnb','ps','sd','ug','ur','yi');

$RTL_languages  = array_map('strtolower', $RTL_languages);
$_extensions[0] = array_map('strtolower', $_extensions[0]);
$_extensions[1] = array_map('strtolower', $_extensions[1]);

$_maxFileSize   = return_bytes(ini_get('upload_max_filesize'));
$_extensions[2] = array("gif", "jpg", "jpeg", "png","bmp","ico","tiff","svg"); //images extensions
$_extensions[3] = array("mp3", "wav", "ogg"); //music extensions
//$_extensions[4] = array('doc', 'docx', 'docm', 'dot', 'dotx', 'dotm', 'wps','pdf'); //formats doc extensions
$_extensions[2] = array_map('strtolower', $_extensions[2]);
$icon[0]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAr0lEQVQ4jbXTsQrCMBAG4AxOgk66ubj5Cg5C3sBX0SVLl3Mp1pb773cQ+jZ9NBcDUmxDg/3hIOSO7yAQ5/6Zsiy3AAoA0q+qqnZJAEARQlg55xzJDoD/3AvJZ+yNARLPfUBENgDMe7/IAQoRWTdNczCz22Tg+21IdpOBoZn5gdTMYFNVT6pKVX1kAWZ2ret6D8CygLZtlwAuAI5ZwFjmBVT1bGb3X58pFslXasmkvAH6z57RLFab2AAAAABJRU5ErkJggg==';
$icon[1]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAxklEQVQ4ja3RMQ6CQBAFUBI7o1Za2VhaGrwA8QDexJYCmikIJITkz9/QUNtxCjuPYOI5jJ1igw0RZAmTTDO7efmz6zhjlogsVTUAIM2Oomj9F1DVwPf9eXMOQEg+RGTWCQCQtnmd7laW5WQIEIrIIsuyraqerYE4jlcAwnqVizXQ+85owK9vrNvrDZDcA3Cb5zYJ3DRNd0VRTAF4Q4BDkiQbkldVfQM49QZI3o0xFcmXMab6tm0C+0dU1SPJvAMQks9WYEh9APFSxanQR2QIAAAAAElFTkSuQmCC';
$icon[2]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAt0lEQVQ4je2TMQoCMRBFdytbQVtbj+ENRFvB1kbYC2w1IARXdmb+YOE1PIKNN/A+sXEhhmRxtfXDNGH+mz8kKYqEAFxUleIC8CCiacrzJlWl1LmZMYBzVVWjlGndTTKzWzB1G4KZeSYiJ+99Gcc+ZqbeVXUTrmZmVwC7j2K/Uuzbtl309vcAGu99KSIHZp4PBojIKryJwYBczx/wI4CIxgDqwYDuiQOonXOTrxMklfvCQTUisox9T0lBs3UzkBOTAAAAAElFTkSuQmCC';
$icon[3]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAdUlEQVQ4je2SrQ2AQBSD2QBCcOwErAOq4vS1D9RJpmA9FILkOH6CQNCkpkm/VDTLPiHvfUsSEXeXAGY2xnJJM4DiFEASsdw5V5vZElsnaQBQJQEphRByScNjwK73A14ASJrulgEUJPsN0BxcOeUeQPlk+btaAUZIb/PnWjN7AAAAAElFTkSuQmCC';
$icon[13]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAXUlEQVQ4jWNgGJbAk4GBIQQP9qXUghCaG+DMwMDARa4BzgwMDEYMDAwsSJiRFAM6GRgYYhkYGAKQsBwpBjAxMDCkMDAwcONRQzAMmKCYbAMIAYIGEEpIWZS6YJABAEwKC7pKuYTEAAAAAElFTkSuQmCC';
$icon[6]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAd0lEQVQ4jWNgoBXo6+vz7+/vb+jv72+YMGFCVUNDgwhJBkyYMGEyjN3Q0MA3YcKEKoKaYDb29/c3TJw48QAevgNeQwhZQtAVxNCjBgx7AzqhtAM6nZuby97f319NyID5fX19XcjJGJqhGidOnHi1q6tLFa8BpAIAcUCizUwVOu0AAAAASUVORK5CYII=';
$icon[7]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAA/ElEQVQ4ja2TPUpDURCFB2wsopVdNuAWYproArKGkM6U0TxIqikeaMi775xTZAXp3nICwdrOBbgAm/sgvN8oDgxc7sz55jCXa/Yf4e53JDcAvJppmg57ASQ37j6o3gNwSd/VWpIkN7XGJjAAj+4+iqK4MjPL81wAnOT7JYC1u99mWXZP8kByBWAba1t3v+4EVHZzBDACMJMUJKW9Ds7qSwCjeH4CsLxoB6U4hPBgZhZCeKyJuwBx8vhM/No2pQYg+VKKAUwkndpc1gAkF+UzAZjE7Te6bARI+gIwl7QjuWpz2QmQ9Angua2nE/DrHpJTkm9Nn6lMkvu+IX+KH1+Xuy051gU6AAAAAElFTkSuQmCC';
$icon[15]='data:image/gif;base64,R0lGODlhHwAfANUAAP///5qamiYmJuTk5Ly8vMzMzKqqqrCwsKKioujo6NTU1Pb29qioqKCgoK6urtLS0tzc3NjY2Li4uObm5nBwcMbGxmhoaEZGRkhISDIyMvj4+Pr6+lBQUDY2NsTExFZWVpKSkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAKAAAAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAHwAfAAAG/0CAcEhMPAgOBKDDoQQKxKh0CJEErleAYLu1HDRT6YCALWu5XEolPIwYymY0GmNgAxrwuJybCUcaAHlYZ3sCdxFRA28BgVgHBQMLAAkeIB9ojQYDRGSDAQwKYRsIF4ZlBFR5AJt2a3kQQlZlDBN2QxMMcBKTeaG2Qwp5RnAHv1EHcEdwUMZDBXBIcKzNq3BJcJLUAAtwStrNCNjf3GUIDtLfA9adWMzUz6cPxN/IZQ8JvdTBcAkAsli0jOHSJQSCqmlhNr0awo7RJ19TFORqdAXVEEVZyjyKtG1AgXoZA2iK8oeiKkFZGiCaggelSTiA2LhxidLASjZjBL2siNBOFQ84LyXA+mYEiRJzBO7ZCQIAIfkEAQoAIQAsEAAAAA8ADwAABldAhIPwSISOyGRguZRAAEkkc0oYREPTqSESzU4bXe8ylDEgF4PCYRoSCDCVKEDBCLTdAormasXjD1chFRd+AhaBIQiFAgWBGx+FdoEghRSIHoUciAmFHUEAIfkEAQoAIQAsFgAFAAkAFQAABlnAkDDUiAyHgYBhcEwmCQCh0wkJTRjTgESoyAYSIcAh+xAWsgThIOsQLrKIo1yYENjtHaHnbucIQXwCFCEbH4EBIQiBAgUVF4EWQosHQ3wUGkd2GBVzGQZDQQAh+QQBCgAhACwQABAADwAPAAAGWcCQcChcBI5HBJE4QB4dy2HBGSBEQ4AD9XFVUAOJ6IRBlUQroS+EuEFcBGkkARBKeEAfgR5+NAyEe4F6IQ0RQ4KBGUuIehgGi4gUaJB7FgcaVx0cFAEFV0NBACH5BAEKACEALAUAFgAVAAkAAAZUwJAwVBkajYOjUHBBbJQhgIIROAqugg/IkwgtBoVDYFxdYs+CEHk9DmXQZzWb3DBg4Ff53BAhUvB6awRJQhoHFmiBARIQAFAFARQcHSEIDgQPXUZBACH5BAEKACEALAAAEAAPAA8AAAZZwI5gOEyEjsgjhzj0JJMUpgD0RAakn001VJAKENuQRXqpbA/e0KCqiRJDAYYC8KxghvCA/lAYLJAGGXl6hHpPDYWJTxEGiYRVAwSOAVsAEBKKYSEJDwQOCEEAIfkEAQoAIQAsAAAFAAkAFQAABlnAkNCQERpDFYxAcNRQlkvjAQoVWqiCS6WAFSBCAexnE3pSQUIO1iPsYBPHuBARqNcXQoe9PhAS9gEFQg+ABwAhCYABCkISgAwTIRCKQgB/dkcDBnVyEQ1HQQAh+QQBCgAhACwAAAAADwAPAAAGWMCQcEgsBCicDnGoOVgEUOgyVKFEr0sD5oolZrjdUKQRAkeFA0MgUI5+QJ5ECEBYr8sXxIYIsdupUxJ+AQwTUwmDAQpTIQ+DBwCMdX4FjCEOgwOWCIMLlkEAOw==';
$icon[12]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyUlEQVQ4jbXSPUtDMQCF4edKkRaHDv0YBHGXDipIpVC4BVel6C9QkNqpCBZEHHRo6VAQ/cUOjXKVYHMLHsjyJudNSMI/poIjnGC7bPkUb7jEOZbIU8sNLJD94q/YTRHcYj/Cm7hPEbxEdi+eIkmwydx3pqhHeBXPKYIDjCP8Gsfryhn2cIcRdlDDDSZWrxC9nwwPmOMqsA4e8YTDwC4wC2u3ioKu1adJzRC9IsgxKCHo46wI2vgIknzNGOA9dH6klVD+Gq0Sp/07n5Y9F3VkGsILAAAAAElFTkSuQmCC';
$icon[4]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAe0lEQVQ4je2RsQ2DQBRDPQFCiCpDkawDlamia84+sUTGyGhUFEgHhBNFCiy5seQn63/gLxRjfEpixq+fALbfG/lIsj4ESGIuDyE8bH9y62wPJNtdwJ5IVrYHAEBK6btxg0MXL1j1bgBgezpbJllL6hdAV/DCnmRTsvxazZqvjASHx2bnAAAAAElFTkSuQmCC';
$icon[11]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAA9UlEQVQ4jc2QTUoDQRCFs0jEn7WuFQ8QFx6gNwYXunP0Cq6EgVkI2XQgzIRuut4rG8HaCV7AI7oxYRwSMhACFjRNP977qroGg39XZjbKORcApiSfiqI46B2u6/pUVd9CCFfOuWFKaUzyPcZ41gugqnMzO25rVVWdkPwiOSO5EJHHjQCSsx5NnlNK43Xhl5xzsQ1QluWRqloI4XIlisiE5F3XLCK3qvrtvT9s6865IUlZCQCmZjZaE35V1U8AH13In++SvBGR+7YBwMPv7ZumOReR640TLHegqnMAvnVc5+0BeJKIMV5s29dyEt/LuE+A2wmw9/oBfgaBG4x+og4AAAAASUVORK5CYII=';
$icon[5]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAhUlEQVQ4jWNgoCZoaGgQmTBhQlV/f38DOm5paZEmaMCECROqysrKeNHF+/v7GyZOnPiloaGBB68B/f39DbjEoa67vmrVKmZyDKhuaGjg6+np0ZgwYcJikg1oa2sT7e/vr4Z65QDJBhCtZtSAYWHAhAkT/CZOnDgFW2aC4YkTJ34jZAlJAADcp3JNo6PIZgAAAABJRU5ErkJggg==';
$icon[10]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAA00lEQVQ4jd3PPQrCQBAF4BWE3EFsvMk2Vl7A1t5tLESwscywsO+91ILXsbJPKVjqDYTYpBCJiX+Vr5xhvplx7v9iZgMAO0kXkldJh5TS9OVhSUdJ0cyGIYSM5BhAKWnVCdSbYxNM8hxjHLUCki5mNmzqkdySnLcCJK8hhOxJLwew7rrgQHL8WK+qqidpD2DSCqSUpgBKMxs8DC8lnbz3/VagvmJF8lz/nEvaSzoVRVEB2HQCzjkXYxyRnANYA5h47/sANm8hTblDFt8gC0mzj4Gf5wYc04KjAuZmyQAAAABJRU5ErkJggg==';
$icon[14]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAwklEQVQ4jb2QPQrCQBCFFyvxBtYKuYOVnZ3nCF7BZpsUG9id96bLDTyDlaWnEGzt0xliJYSwJOvvg9cMzPfejDG/UlEUc5K5iOwBbIwxk+RlAFsAtaq2TwM4VlU1S0oGUJM8O+cya+0UwI5kQ9KPAkjmqto657JeqwPJ2yhARKyqtqnz7wIABJJN93l9k7yGEJZRQGyZ5ElEbNfe+1UUMJTctYjYZECsgYis/wd46YSPnxhCKAHch9IBXMqyXEQB7+gBtIEmVWp3raAAAAAASUVORK5CYII=';
$icon[9]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SMU7DQBBFp+UacACKXMCNJYLCCVxzHDf2CfAqVdaz402NiJK0WRcUuUBAlAEbClJ8CuLIctaS63xpNdJo9Pft7Cc6Kk1TkEeFtcIiyI2BZsbrdqt9c0REI1+TRdBo4xwAIDfm3KSPgEXw9v4BAFiu1tg4BxbxznoJjLXY7z/xXf+cSDTzuUFD0NQkSRDH8a1Yi9/DAVVd46uqAAAzn0GLoF2vZD5HV7nvCX07yJR6ZhFoZmhm5CLIlHoZvAMiuh5PJg9BENyFYXh/nLsZTCDW6iYHLAIuip33miiKHn39dg5cWQIAWGQ2mKCbA1eWF5uDPmXT6aKbgyelFoMN6P/PR51zysEf2/RBFJCWMhsAAAAASUVORK5CYII=';
$icon[8]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAlElEQVQ4jWNgoCZoaGgQmTBhQlV/f38DOm5paZEmaMCECROqysrKeNHF+/v7GyZOnPiloaGBB68B/f39DTAaCTv09/c3QF13fdWqVcwEDcAiXt3Q0MDX09OjMWHChMUku6CtrU20v7+/GuqVA6QagOEdkr1AtBqquWDUCxR4YcKECX4TJ06cgscFDRMnTvxGyBKSAADats4cMtUnDAAAAABJRU5ErkJggg==';

/*---------------------------english -------------------*/

$lang[0] =  'en';
$lang[1] =  'Remove';
$lang[2] =  'Edit';
$lang[3] =  'Preview';
$lang[4] =  'home';
$lang[5] =  'Filename';
$lang[6] =  'Size';
$lang[7] =  'Extension';
$lang[8] =  'Actions';
$lang[9] =  'Page';
$lang[10] =  'Total files';
$lang[11] =  'File Manager';
$lang[12] =  'by';
$lang[13] =  'Are you sure you want to Remove this file';
$lang[14] =  'Save';
$lang[15] =  'Cancel';
$lang[16] =  'Folder';
$lang[17] =  'Sending ...';
$lang[18] =  'Browse directorie';
$lang[19] =  'Search';
$lang[20] =  'Rename';
$lang[21] =  'Unable to open file!';
$lang[22] =  'Sign in';
$lang[23] =  'Login';
$lang[24] =  'Username';
$lang[25] =  'Password';
$lang[26] =  'Logout';
$lang[27] =  'About';
$lang[28] =  'Last modified';
$lang[29] =  'New folder';
$lang[30] =  'Upload file';
$lang[31] =  'Match not found';
$lang[32] =  'Browse ... ';
$lang[33] =  'Error';
$lang[34] =  'Success';
$lang[35] =  'Loading ...';
$lang[36] =  'Allowed extensions';
$lang[37] =  'Max filesize';
$lang[38] =  'Not exists';
$lang[39] =  'Tree View';
$lang[40] =  'Copy to';
$lang[41] =  'UnZip file';
$lang[42] =  'Information';
$lang[43] =  'Empty';

$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

/*----------------------------------------------*/

    $is_rtl=false;
if( in_array( $lang[0], $RTL_languages  ) ) 
	$is_rtl=true;


function Login()
{
	global $login_user,$login_pass;
	if(isset($_SESSION['login']))
	{
	if($_SESSION['login']['user'] ==$login_user && $_SESSION['login']['pass'] ==$login_pass && $_SESSION['login']['status'] =="1")
		return true; else return false;	
	}  else return false;	
	
}

function print_array($array)
{
	global $charset;
	header("Content-type: application/json; charset=".$charset);
	return json_encode($array);
}

function recurse_copy($src,$dst) { 
 if ( is_file($src) )
 {
	 $_DIRNAME = pathinfo($dst, PATHINFO_DIRNAME);
     if(!file_exists($_DIRNAME))
        @mkdir($_DIRNAME, 0777, true); 
    return @copy($src,$dst); 
 }
     
    $dir = opendir($src); 
	if(!file_exists($dst))
       @mkdir($dst, 0777, true); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 
function openZipArchive($file,$extract_path)
{
	global $alert_msg,$lang;
	if(!file_exists($extract_path))
    @mkdir($extract_path, 0777, true); 

$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
  $zip->extractTo($extract_path);
  $zip->close();
   return true;
} else {
  $alert_msg=$lang[33].' - '.$lang[41];
  return false;
}	
}


function unlinkRecursive($dir, $RemoveRootToo)
{
	 if (is_file($dir) === true)
     return @unlink($dir);  
    if(!$dh = @opendir($dir))
     return;   
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..')
        continue;
        if (!@unlink($dir . '/' . $obj))
        unlinkRecursive($dir.'/'.$obj, true);       
    }
    closedir($dh);
    if ($RemoveRootToo)
     @rmdir($dir);    
    return;
}



function return_bytes ($size_str)
{
    switch (substr ($size_str, -1))
    {
        case 'M': case 'm': return (int)$size_str * 1048576;
        case 'K': case 'k': return (int)$size_str * 1024;
        case 'G': case 'g': return (int)$size_str * 1073741824;
        default: return $size_str;
    }
}

function is_sub_dir($path = NULL, $parent_folder = SITE_PATH) {
    $dir = dirname($path);
    $folder = substr($path, strlen($dir));
    $dir = realpath($dir);
    $folder = preg_replace('/[^a-z0-9\.\-_]/i', '', $folder);
    if( !$dir OR !$folder OR $folder === '.') {
    	return FALSE;
    }
    $path = $dir.'/'. $folder;/*DS*/
    if( strcasecmp($path, $parent_folder) > 0 ) {
    	return $path;
    }
    return FALSE;
}
function text_position($position=0)
{
global $is_rtl;
if($position==0)
{if($is_rtl ) echo 'left'; else echo 'right';}
else
{if($is_rtl ) echo 'right'; else echo 'left';}	
}

function css()
{  
global $is_rtl;	
$css='';

if(file_exists('./css/bootstrap.min.css'))
    $css.='<link href="./css/bootstrap.min.css" rel="stylesheet">';
else
	$css.='<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';

if(file_exists('./js/jquery-2.2.0.min.js'))
	$css.='<script src="./js/jquery-2.2.0.min.js"></script>';
else
	$css.='<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>';

if(file_exists('./js/bootstrap.min.js'))
	$css.='<script src="./js/bootstrap.min.js"></script>';
else
	$css.='<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';

if(file_exists('./js/jquery.twbsPagination.min.js'))
	$css.='<script src="./js/jquery.twbsPagination.min.js"></script>'; 
else 
	$css.='<script src="//raw.githubusercontent.com/esimakin/twbs-pagination/develop/jquery.twbsPagination.min.js"></script>';

if( $is_rtl ) 
if(file_exists('./css/bootstrap-rtl.min.css'))
	$css.='<link href="./css/bootstrap-rtl.min.css" rel="stylesheet">';
else  
	$css.='<link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">';
         	
	return $css;

} 	
function alert($str)
{
	global $lang;
	return '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$lang[33].'!</strong> '.$str.'</div>';
}

function  AJAX_request()
{
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	return true ; else return false; 
}


if(!Login() && $LoginDialog && ( isset($_GET['uploadfile']) || isset($_GET['listFolderFiles']) || isset($_GET['copy']) || isset($_GET['unzip']) || isset($_GET['table']) || isset($_GET['rename']) || isset($_GET['Remove']) || isset($_GET['read']) || isset($_GET['newfolder']) )  )
{

  die(print_array(array( 'table' => '<div class="container_01"><center>'.$lang[31].'</center></div>' , 'total' => 1 , 'page' => 1, 'dir' => '' , 'dirHtml' => '' ,'alert' => alert($lang[22])  )));
}


if(!Login() && $LoginDialog)
{
	if($login_user=='')
		$html_input_user='<input name="username" value="" type="hidden" >';
	else
		$html_input_user='<div class="input-group" style="margin-top:10px;">
                           <span class="input-group-addon"><i class="UserIcon"></i></span>
                           <input id="user" type="text" class="form-control" name="username" value="" placeholder="'.$lang[24].'">                                        
                         </div>';
echo ('<!DOCTYPE html>
<html>
<head>
<title>'.$lang[22].'</title>
<meta charset="'.$charset.'">
<link href="'.$icon[12].'" rel="icon" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
'.css().'
<style>
body {background: #F1F1F1 none repeat scroll 0% 0%;}
.UserIcon{background:url( '.$icon[12].') no-repeat left center;padding: 5px 0 5px 20px;}
.PassIcon{background:url( '.$icon[14].') no-repeat left center;padding: 5px 0 5px 20px;}
</style>
</head>
<body>
<div class="container">
 <div class="col-sm-4 col-sm-offset-4" style="margin-top:50px;">
		<div class="well" style="background-color: #FFF;">
      <legend>'.$lang[22].'</legend>
    <form accept-charset="'.$charset.'" action="" method="post">'.$html_input_user.'
		          
                    <div class="input-group" style="margin-top:10px;">
                        <span class="input-group-addon"><i class="PassIcon"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="'.$lang[25].'">
                    </div>  
					
        <button class="btn btn-info btn-block" style="margin-top:10px;"  type="submit">'.$lang[23].'</button>
    </form>
	    </div>
  </div>
</div>


</body>
</html>');
	unset($lang);
	unset($icon);
	unset($_extensions);
    unset($RTL_languages);
	unset($LoginDialog);
	unset($login_user);
	unset($login_pass);
	unset($is_rtl);
	unset($units);
	unset($charset);
	unset($_maxFileSize);
    unset($_SERVER); unset($_SESSION);unset($_COOKIE);unset($_GET);  unset($_POST);unset($_FILES);unset($_ENV); unset($_REQUEST); 

exit();
}


$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
if(!($page>0)) $page = 1;
$directory = (isset($_GET['dir'])) ? $_GET['dir'] : '.';

if(isset($_GET['copy']) /*&& AJAX_request()*/ ) {file_exists_str($_GET['copy']); recurse_copy( $_GET['copy'],$_GET['to'] );  } 
if(isset($_GET['Remove']) && AJAX_request() ) {file_exists_str($_GET['Remove']);@unlinkRecursive($_GET['Remove'],true);	} 
if(isset($_GET['newfolder']) && AJAX_request() ) {@mkdir(  $directory .'/'.$_GET['newfolder'] , 0777, true);	} 
if(isset($_GET['rename']) && AJAX_request() ) {file_exists_str($_GET['rename']);@rename($_GET['rename'],$directory .'/'.$_GET['newrename']);} 
if(isset($_GET['unzip']) && AJAX_request() ) {file_exists_str($_GET['unzip']);@openZipArchive($_GET['unzip'],$_GET['to']);} 
if(isset($_GET['listFolderFiles'])  && AJAX_request() ) {die(listFolderFiles($directory));} 

if(isset($_GET['read']) && $show_file_or_dir && AJAX_request() ) {file_exists_str($_GET['read']);if(in_array(extension($_GET['read']), $_extensions[1]) || count($_extensions[1])==0 )
	{   header('Content-type: text/html; charset='.$charset);
		die( _read($_GET['read']) ) ; 
	}   else die($lang[7]);} 
	
if(isset($_GET['write']) && $show_file_or_dir && AJAX_request() ) {file_exists_str($_POST['write']);if(in_array(extension($_POST['write']), $_extensions[1]) || count($_extensions[1])==0 )
	{   header('Content-type: text/html; charset='.$charset);
        $txtData = (isset($_POST['txt'])) ? $_POST['txt'] : '';
		die( _write($_POST['write'],$txtData) ) ; 
	}   else die($lang[7]);} 
	
 if ( isset($_GET['uploadfile']) && AJAX_request() ) { 
 
 $response = array();
 if (isset( $_FILES["inputFileUpload"] ) && !empty( $_FILES["inputFileUpload"]["name"] ) )
 if (is_array($_FILES['inputFileUpload']['name']) || is_object($_FILES['inputFileUpload']['name']))
 foreach($_FILES['inputFileUpload']['name'] as $n => $name) {
	
	if(!empty($name)) {	
	$tmp_name = basename($name);
	$tmp_size = $_FILES["inputFileUpload"]["size"][$n] ;
	$tmp_type = $_FILES["inputFileUpload"]["type"][$n] ;
	$error    = $_FILES["inputFileUpload"]["error"][$n] ;
	$name_    = $_FILES["inputFileUpload"]["name"][$n] ;
	$target_file = $directory .'/'.$tmp_name; 	
		
// )
if( in_array(extension($tmp_name), $_extensions[0]  ) || count($_extensions[0]) ==0 )
 {
	
if(move_uploaded_file($_FILES["inputFileUpload"]["tmp_name"][$n], $target_file))	
    $response[] =array( 'code' => '1','status' => $lang[34] ,'url' => $target_file , 'tmp_name' =>  $tmp_name , 'size' => $tmp_size , 'type' => $tmp_type , 'error' => $error , 'name' => $name_);
elseif($error!=0)
    $response[] =array( 'code' => '0','status' => $lang[33].'_'.$error );	
elseif($tmp_size>$_maxFileSize)
    $response[] =array( 'code' => '0','status' => $lang[37] );		
else
	$response[] =array( 'code' => '0','status' => $lang[33] );	
	
 } else $response[] = array( 'code' => '0','status' => $lang[7] );  
} else $response[] = array( 'code' => '0','status' => $lang[38] );  
}

  die(print_array($response));										
 
}; //$alert_msg=$lang[38];

//exit(header('Location: ?page='.$page.'&dir='.$directory.'"'));

if (!function_exists('scandir')) {
    function scandir($dir, $sortorder = 0) {
        if (is_dir($dir)) {
            $files = [];
            if ($dirlist = opendir($dir)) {
                while (($file = readdir($dirlist)) !== false) {
                    if ($file != '.' && $file != '..') {
                        $files[] = $file;
                    }
                }
                closedir($dirlist);
                ($sortorder == 0) ? asort($files) : rsort($files);
            }
            return $files;
        } else {
            return false;
        }
    }
}



function folderSize ($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
}

function FilterScanDir($dir)
{
	global $_extensions,$directory;
$times	= array() ;
$files_tmp = array() ;	
$folers_tmp = array() ;	
$total_files = 0;
$files = (is_dir($dir)) ? @scandir($dir) : array() ;	
if (is_array($files) || is_object($files))
foreach($files as $file)
if(  ( in_array(extension($file), $_extensions[0] ) || count($_extensions[0]) ==0 ) && $file !=='.'  )	
{
	if($file !=='..')
	$total_files++;

    if(is_dir($file))
	 $folers_tmp[]=$file;
    else
	 $files_tmp[]=$file;
 
	$times[] = date ("d/m/Y H:i:s", @filemtime($directory.'/'.$file));
}
//arsort($files_tmp);
//$files = array_keys($files_tmp);
//array_multisort(array_map('filemtime', $files_tmp ), SORT_DESC, $files_tmp);
return array( 'list' => array_merge($folers_tmp,$files_tmp)  ,'times' => $times , 'count' => $total_files );
}

function listFolderFiles($dir){
	global $_extensions;
	 if (is_file($dir) === true) 
		 return ;
    $ffs = scandir($dir);
    echo ' <ul>';
	if (is_array($ffs) || is_object($ffs))
    foreach($ffs as $ff){ 
        if($ff != '.' && $ff != '..' &&  ( in_array(extension($ff), $_extensions[0]  ) || count($_extensions[0]) ==0 )  ){
            echo '<li><a href="'.$dir.'/'.$ff.'">'.$ff;
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</a></li>';
        }
    }
    echo '</ul>';
}

$total_files = 0;

$offset = ($page-1)*$perpage;
//setcookie('directory', $directory, time() + (86400 * 30), "/");

//get subset of file array
$FilesArray = FilterScanDir($directory);
$files      = $FilesArray['list'];
$times      = $FilesArray['times'];
$total_files= $FilesArray['count'];


//$files = (isset($files_tmp) && is_array($files_tmp)) ? $files_tmp : array();
if(isset($_GET['search']))
{
unset($files);
$files = array();
$total_files = 1;
if (in_array($_GET['search'], $FilesArray['list']))  
  $files[0] = $_GET['search']; 
else 
  $files[0] = 'Match_not_found';
}
if($table_fixed=='')
$total_pages = ceil($total_files/$perpage);
else
$total_pages = 1;	

unset($FilesArray);

if($table_fixed=='')
$files = array_slice($files, $offset, $perpage);


function showfile($file)
{
global $directory,$_extensions,$lang;

if($file=='.' )		
	return '<a href="?" onclick="getContent('."'dir=".$directory.'/'.$file."'".',0); return false;"><strong>'.$file.'</strong></a>';

elseif($file=='Match_not_found')
    return '<span class="ExplorIcon">'.$lang[31].'</span>';
	
elseif($file=='..' )
    return '<span class="TreeIcon"></span><a href="?" onclick="getContent('."'dir=".$directory.'/'.$file."'".',0); return false;">'.$file.'</a>';

elseif(is_dir($directory.'/'.$file) && file_exists($directory.'/'.$file) )	
	return '<span class="CFolderIcon"></span><a href="?" onclick="getContent('."'dir=".$directory.'/'.$file."'".',0); return false;">'.$file.'</a>';
	
elseif (in_array(extension($file), $_extensions[2]  ))
	return  '<span class="ImageIcon"></span><a href="'.$directory.'/'.$file.'">'.$file.'</a>' ;
	
elseif (in_array(extension($file), array("zip","rar","7z","gzip","tar","wim","xz")  ))
	return '<span class="ZipIcon"></span><a href="'.$directory.'/'.$file.'">'.$file.'</a>' ;
	
else
	return '<span class="PhpIcon"></span><a href="'.$directory.'/'.$file.'">'.$file.'</a>';
}

function extension($file)
{
	global $lang;
if($file=='Match_not_found')
	return '--'; 
$extension=strtolower(pathinfo($file, PATHINFO_EXTENSION ))	;
if($extension=='') 
	return 'dir';//$lang[16] ; 
else 
	return $extension; //ucfirst
}


function file_exists_str($file)
{
	global $alert_msg,$lang;
	if(!file_exists($file))
		$alert_msg=$lang[38];
}
function file_size($file)
{
global $directory;
return @filesize_formatted($directory.'/'.$file);	
}


function action($file)
{
global $directory,$page,$show_file_or_dir,$lang,$total_files,$_extensions;
if($file=='Match_not_found' )
	return '--'; 
if( $file =='..')
	return '--'; 

$html= '<a data-toggle="tooltip" title="'.$lang[1].'" onclick="SetRemoveModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="RemoveIcon"></span></a> ';
if($show_file_or_dir)
{
	if(is_dir($directory.'/'.$file))
	{
		$count=FilterScanDir($directory.'/'.$file); //$count=FilterScanDir($directory.'/'.$file)['count'];
		$count=$count['count'];
		$html.='<a data-toggle="tooltip" title="'.$lang[18].'"  onclick="SetShowFileModalattr('."'".$directory.'/'.$file.'/&perpage='.$count."&#directory'".'); return false;"  href="#"><span class="OFolderIcon"></span></a> ' ;	 
        unset($count);		
	}
		
	elseif (in_array(extension($file), $_extensions[2]  ))
	   $html.='<a data-toggle="tooltip" title="'.$lang[3].'" onclick="SetShowFileModalattr('."'".$directory.'/'.$file."'".'); return false;" href="#"><span class="ImageIcon"></span></a> ' ;
	elseif (in_array(extension($file), array("zip","rar","7z","gzip","tar","wim","xz")  ))
	   $html.='<a data-toggle="tooltip" title="'.$lang[41].'" onclick="SetZipFileModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="ZipIcon"></span></a> ' ;
	else	
       $html.='<a data-toggle="tooltip" title="'.$lang[3].'" onclick="SetShowFileModalattr('."'".$directory.'/'.$file."'".'); return false;" href="#"><span class="ShowIcon"></span></a> ' ;
}
$html.='<a data-toggle="tooltip" title="'.$lang[40].'" onclick="SetCopyFileModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="CopyIcon"></span></a>';	
$html.='<a data-toggle="tooltip" title="'.$lang[20].'" onclick="SetRenameModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="RenameIcon"></span></a>';	
    return $html;
}

function _read($file,$Modes="r")
{
global $lang;

$file_size = filesize($file);
if( !$file_size || !is_readable($file) ) return $lang[21];

$myfile = fopen($file, $Modes) ;
if(!$myfile) return $lang[21]; //w
return fread($myfile, $file_size );
fclose($myfile);
};

function _write($file,$txt='',$Modes="w")
{
global $lang;

if(file_exists($file) && $txt=='') return $lang[43];

if( file_exists($file) && ( !filesize($file) || !is_readable($file) ) ) return $lang[21];

$myfile = fopen($file, $Modes) ;
if(!$myfile) return $lang[21]; //w
if ( fwrite($myfile, $txt ) )
{
fclose($myfile);
return $lang[34];
}	else {
	     fclose($myfile);
         return $lang[33];
         }

};

function GetOldirectory()
{
global $directory,$page,$lang;

$html='<li><a href="#" onclick="getContent('."'dir=."."'".',0); return false;">'.$lang[4].'</a></li>';
$newDir='.';
$elements = explode('/',$directory);
if (is_array($elements) || is_object($elements))
foreach ( $elements as $key_value )
{
	if($key_value!='.'){
	$newDir = $newDir.'/'.$key_value;
	$html.='<li><a href="#" onclick="getContent('."'dir=".$newDir.'&page='.$page."'".',0); return false;">'.$key_value.'</a></li>';
	}
}

return $html;
}

function filesize_formatted($path)
{
global $units ;
	if(is_dir($path) || $path=='./Match_not_found' ) return '--';//directory 
    $size = filesize($path);
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
function fileTime($index,$file)
{ 
global $times ;
if($file=='Match_not_found') return '--';
return $times[$index];
};

if(isset($_GET['table']) && AJAX_request() )
{
	
$html='<div class="table-responsive"><table class="table table-hover '.$table_fixed.'"><thead><tr>';
	if($table_fixed=='')
	$html.='<th class="col-md-4">'.$lang[5].'</th><th class="hidden-xs col-md-2">'.$lang[6].'</th><th class="hidden-xs col-md-2">'.$lang[7].'</th><th class="hidden-xs col-md-2">'.$lang[28].'</th>';
	else
	$html.='<th class="col-xs-12 col-sm-6">'.$lang[5].'</th><th class="hidden-xs col-xs-2 col-sm-2 col-md-2">'.$lang[6].'</th><th class="hidden-xs col-xs-2 col-sm-2 col-md-2">'.$lang[7].'</th>';

    $html.='<th class="hidden-xs col-md-2">'.$lang[8].'</th></tr></thead><tbody>';
//output appropriate items
if (is_array($files) || is_object($files))
foreach($files as $index => $file )
{
	$html.='<tr>';
	if($table_fixed=='')
	$html.='<td class="col-md-3">'.showfile($file).'</td><td class="hidden-xs col-md-2">'.file_size($file).'</td><td class="hidden-xs col-md-2">'.extension($file).'</td><td class="hidden-xs col-md-2">'.fileTime($index,$file).'</td>';
	else
	$html.='<td class="col-xs-12 col-sm-5">'.showfile($file).'</td><td class="hidden-xs col-xs-2 col-sm-2 col-md-2">'.file_size($file).'</td><td class="hidden-xs col-xs-2 col-sm-2 col-md-2"><span class="label label-default">'.extension($file).'</span></td>';

	$html.='<td class="hidden-xs col-xs-3 col-sm-3 col-md-3">'.action($file).'</td></tr>'; 
}


$html.='<tr>';
if($table_fixed=='')
$html.='<td colspan="5" class="col-xs-12 col-sm-12 col-md-12">';
else
$html.='<td colspan="4" class="col-xs-12 col-sm-12 col-md-12">';	
$html.=$lang[9].' : <mark>'.$page.'</mark> '.$lang[10].' : <mark>'.$total_files.'</mark></td></tr></tbody></table></div>';
if($alert_msg!='') 
	$alert_msg = alert($alert_msg);
  $response = array( 'table' => $html , 'total' => $total_pages , 'page' => $page , 'dir' => $directory , 'dirHtml' => GetOldirectory() ,'alert' => $alert_msg);
  unset($html); 
  die(print_array($response));
  
}

// free memory
unset($files);
unset($times);
//unset($directory);
unset($total_files);
//unset($page);
unset($offset);
//unset($total_pages);
unset($perpage);
unset($table_fixed);
unset($RTL_languages);
unset($show_file_or_dir);
unset($alert_msg);
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>	
	    <meta charset="<?php echo $charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <?php echo css();?>  
		<link href="<?php echo $icon[4];?>" rel="icon" type="image/x-icon" />
		<title><?php echo $lang[11]; ?></title>
        
		<style>

.ZipIcon {background:url(<?php echo $icon[0];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.ImageIcon {background:url(<?php echo $icon[1];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.CopyIcon {background:url(<?php echo $icon[2];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}		
.CFolderIcon {background:url(<?php echo $icon[3];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.OFolderIcon {background:url(<?php echo $icon[4];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.PhpIcon{background:url( <?php echo $icon[5];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.RemoveIcon {background:url(<?php echo $icon[6];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.RenameIcon{background:url( <?php echo $icon[7];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.ShowIcon {background:url(<?php echo $icon[8];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.TreeIcon{background:url( <?php echo $icon[9];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.ExplorIcon{background:url( <?php echo $icon[10];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.UploadIcon{background:url( <?php echo $icon[11];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.UserIcon{background:url( <?php echo $icon[12];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.LogoutIcon{background:url(  <?php echo $icon[13];?>) no-repeat left center;