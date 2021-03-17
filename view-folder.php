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
	
	function read_dir($path, $icons_root_folder, $folder){
		$full_html = "";
	
        //Reads dirctories
		  $full_path = trim_trailing_slash($icons_root_folder) . "/" . $folder;
		  $dirFiles = array();
	  
		  $dirHandle = opendir($full_path);
		  while($item = readdir($dirHandle)) {
			$newPath = $full_path."/".$item;
		
			//A new file
			$path_info = pathinfo($item);
			if(($path_info['extension'] == 'jpg')||
				($path_info['extension'] == 'png')) {
				 $dirFiles[] = $newPath;
			
			}
			
		  }
	  
		  sort($dirFiles);			//Sort alphabetically
		  foreach($dirFiles as $newPath)
		  {
				global $root_server_url;						
			
				$filename = $path . "/" . $newPath;
				$url = $root_server_url . "/" . $path . "/" . $newPath;
				//It's a jpg or png image file
				$full_html .= "<a href=\"javascript:\" onclick=\"return insertEmoticon('" . $filename . "', '" . $url . "');\"><img width=\"100\" src=\"" . $url . "\"></a>";
		  }

		return $full_html;
			  
	}
	
	$path = 'plugins/emoticons_large';
	$icons_root_folder = "icons";
	$html = read_dir($path, $icons_root_folder, $_REQUEST['folder']);
	echo $html;
	
	
?>