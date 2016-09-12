<?php


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

	$start_path = $emoticons_large_config['serverPath'];
	error_log("Server path:" . $start_path);
	$notify = true;		//this switches on notifications from this message
	$staging = $emoticons_large_config['staging'];
	if($staging == 1) {
		$staging = true;
	}
	error_log("Staging: " . $staging);
	include_once($start_path . 'config/db_connect.php');	
	
    $define_classes_path = $start_path;     //This flag ensures we have access to the typical classes, before the cls.pluginapi.php is included
	require($start_path . "classes/cls.pluginapi.php");

    $api = new cls_plugin_api();

	global $root_server_url;
	$message = $_REQUEST['icon'];  //icon is e.g. http://yoururl.com/api/plugins/emoticons_large/icons/sample-set/pirate.jpg
	$sender_ip = "92.27.10.17";		//Can be anything, but must be something
	
	
	
	$forum = $api->get_forum_id($_REQUEST['passcode']);
	
	$username = $_COOKIE['your_name'];
	if(!$username) {
		$username = $_SESSION['temp-user-name'];
	}
	
	error_log("About to try sending: " . $_COOKIE['your_name'] . "  Message:" . $message . "  Whisper to:" . $_REQUEST['whisper_to'] . "  Send email:" . $_REQUEST['email'] . "  Sender ip:" . $sender_ip . "  Forum id:" . $forum['forum_id']);

	$api->new_message($_COOKIE['your_name'], $message, $_REQUEST['whisper_to'], $_REQUEST['email'], $sender_ip, $forum['forum_id'], false);
	
	error_log("Finished sending!");


?>