<?php

	function trim_trailing_slash_local($str) {
        return rtrim($str, "/");
    }
    
    function add_trailing_slash_local($str) {
        //Remove and then add
        return rtrim($str, "/") . '/';
    }

    if(!isset($emoticons_large_config)) {
        //Get global plugin config - but only once
        $data = file_get_contents (dirname(__FILE__) . "/config/config.json");
        if($data) {
            $emoticons_large_config = json_decode($data, true);
            if(!isset($emoticons_large_config)) {
                echo "Error: emoticons_large config/config.json is not valid JSON.";
                exit(0);
            }
        } else {
            echo "Error: Missing config/config.json in emoticons_large plugin.";
            exit(0);
        }
    }

	$start_path = add_trailing_slash_local($emoticons_large_config['serverPath']);
	$notify = true;		//this switches on notifications from this message
	$staging = $emoticons_large_config['staging'];
	if($staging == 1) {
		$staging = true;
	}
	include_once($start_path . 'config/db_connect.php');	
	
    $define_classes_path = $start_path;     //This flag ensures we have access to the typical classes, before the cls.pluginapi.php is included
	require($start_path . "classes/cls.pluginapi.php");

    $api = new cls_plugin_api();

	global $root_server_url;
	global $local_server_path;
	
	//Get the image size so that we can calculate exactly how big to make this image
	$fullfile = $start_path . "./" . $_REQUEST['filename'];
	$size_array = getimagesize($fullfile);
	if($size_array) {
		$cur_width = $size_array[0];
		$target_width = 200;
		$cur_height =  $size_array[1];
		$target_height = intval(($cur_width / $target_width) * $cur_height);
		$message = "<img class=\"img-responsive\" border=\"0\"  width=\"" . $target_width . "\" height=\"" . $target_height . "\" src=\"" . $_REQUEST['icon'] . "\">";  //icon is e.g. http://yoururl.com/api/plugins/emoticons_large/icons/sample-set/pirate.jpg
		$sender_ip = $api->get_current_user_ip();	
	
	
	
	
	
		$forum = $api->get_forum_id($_REQUEST['passcode']);
	
		if(isset($_REQUEST['sender_name']) ) {
			$username = $_REQUEST['sender_name'];
		} else {
			if(isset($_SESSION['temp-user-name']) ) {		
				$username = $_SESSION['temp-user-name'];
			}
		}
		if($username == "") {
			global $msg;
			global $lang;
			$username = $msg['msgs'][$lang]['anon'] . " " . substr($sender_ip, -2);
		}
				

		$api->new_message($username, $message, $_REQUEST['whisper_to'], $_REQUEST['email'], $sender_ip, $forum['forum_id'], false);
		$api->complete_parallel_calls();
	
	} else {
		error_log("No image at " . $fullfile);
	}
?>