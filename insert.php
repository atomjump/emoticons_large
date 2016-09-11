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
	$notify = false;
	include_once($start_path . 'config/db_connect.php');	
	
    $define_classes_path = $start_path;     //This flag ensures we have access to the typical classes, before the cls.pluginapi.php is included
	require($start_path . "classes/cls.pluginapi.php");

    $api = new cls_plugin_api();

	global $root_server_url;
	$message = $root_server_url . "/plugins/emoticons_large/icons/" . $_REQUEST['icon'];  //icon is e.g. sample-set/pirate.jpg
	$sender_ip = "192.168.1.1";		//Can be anything, but must be something
	$options = array();
	
	
	
	list($forum_id, $access_type, $forum_group_user_id) = $api->get_forum_id($_REQUEST['passcode']);
	
	error_log("About to try sending: " . $_COOKIE['your_name'] . "  Message:" . $message . "  Whisper to:" . $_REQUEST['whisper_to'] . "  Send email:" . $_REQUEST['email'] . "  Sender ip:" . $sender_ip . "  Forum id:" . $forum_id;

	$api->new_message($_COOKIE['your_name'], $message, $_REQUEST['whisper_to'], $_REQUEST['email'], $sender_ip, $forum_id, $options);
	



?>