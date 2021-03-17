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
		$full_path = trim_trailing_slash_local($icons_root_folder) . "/" . $folder;
		
		$dir_files = array();
	  
	  	//Check if an 'include.json' file exists in this folder
	  	$include_file = add_trailing_slash_local($full_path) . "include.json";
	  	if(file_exists($include_file)) {
	  	
	  		//Yes, get the file list from the include file
	  		$include_data = file_get_contents($include_file);
	  		if($include_data) {
	  			$json_include = json_decode($include_data);
	  			if(!isset($json_include)) {
                	echo "Error: emoticons_large " . $include_file ." is not valid JSON.";
               		exit(0);
               	}
               	
            	
               	//Valid .json data. Get the array of files to use               	
               	for($cnt = 0; $cnt< count($json_include->displayFiles); $cnt++) {
               		
               		if(($staging != true)&&
						(strpos($json_include->displayFiles[$cnt], "update-emoticons") !== false)) {
							//For production servers remove any files that include 'update-emoticons', which is a special case on staging servers to update the latest icons on the server.
							
					} else {
               			//A normal image
               			$dir_files[] = $full_path . "/" . $json_include->displayFiles[$cnt];
               		}
               	}
               	
            } else {
            	echo "Error: emoticons_large " . $include_file ." could not be read properly.";
               	exit(0);
            }
	  	} else {
	  		//Use alphabetical sorting of all the image files in the folder
			$dir_handle = opendir($full_path);
			while($item = readdir($dir_handle)) {
				if(($staging != true)&&
					(strpos($item, "update-emoticons") !== false)) {
							//For production servers remove any files that include 'update-emoticons', which is a special case on staging servers to update the latest icons on the server.
							
				} else {
					//A normal image
					$new_path = $full_path ."/". $item;
		
					//A new file
					$path_info = pathinfo($item);
					if(($path_info['extension'] == 'jpg')||
						($path_info['extension'] == 'png')||
						($path_info['extension'] == 'gif')) {
						 $dir_files[] = $new_path;
			
					}
				}
			
			}	  
			sort($dir_files);			//Sort alphabetically
		}
		
		
		
		
		foreach($dir_files as $new_path)
		{
				global $root_server_url;						
			
				$filename = $path . "/" . $new_path;
				$url = $root_server_url . "/" . $path . "/" . $new_path;
				//It's a jpg or png image file
				$full_html .= "<a href=\"javascript:\" onclick=\"return insertEmoticon('" . $filename . "', '" . $url . "');\"><img width=\"100\" src=\"" . $url . "\"></a>";
		}

		return $full_html;
			  
	}
	
	
	$staging = $emoticons_large_config['staging'];
	error_log("Staging: " . $staging);		//TESTING
	if($staging == 1) {
		$staging = true;
	}
	
	$path = 'plugins/emoticons_large';
	$icons_root_folder = "icons";
	$html = read_dir($path, $icons_root_folder, $_REQUEST['folder']);
	echo $html;
	
	
?>