<?php
    include_once("classes/cls.pluginapi.php");

    class plugin_emoticons_large
    {
        
        
        
        public function readDirs($path){
        	//Reads dirctories
			  $dirHandle = opendir($path);
			  while($item = readdir($dirHandle)) {
				$newPath = $path."/".$item;
				if(is_dir($newPath) && $item != '.' && $item != '..') {
				   //New Folder
				   //echo "Found Folder $newPath<br>";
				   $this->readDirs($newPath);
		   
				} else {
					//A new file
					$path_info = pathinfo($item);
					if(($path_info['extension'] == 'jpg')||
						($path_info['extension'] == 'png')) {
						
						global $root_server_url;						
						
						$filename = $newPath;
						$url = $root_server_url . "/" . $newPath;
						//It's a jpg or png image file
						?>
						<a href="javascript:" onclick="return insertEmoticon('<?php echo $filename ?>', '<?php echo $url ?>');"><img width="200" src="<?php echo $url ?>"></a>	
						<?php
					}
						 
				}
			  }
		}
        
        
        public function on_upload_screen()
        {
        	global $root_server_url;
        	
        	
        	
        	//Then list through all the icons in that set
        	
        	
        	
        	?>
        	<script>
        		function insertEmoticon(filename, url)
        		{
        			
					var data = $('#comment-input-frm').serialize();
					data = data + "&icon=" + url + "&filename=" + filename;
					data = data + "&sender_name=" + encodeURIComponent($('#your-name-opt').val());
	
	
					$.ajax({
							url: "<?php echo $root_server_url ?>/plugins/emoticons_large/insert.php", 
							data: data,
							type: 'POST',
							cache: false
							}).done(function(response) {
        						//Now switch back to the main screen
        						doSearch();
        						$("#comment-popup-content").show(); 
								$("#comment-upload").hide(); 
        					}
        			);
        			
        			return false;
        		}
        	
        	</script>
        	
        	
        	<h4>Emoticons</h4>
        	
        	<?php 
				//Get a list of all the icon sets (i.e. the directories in each set)
			
				
			
				$path = 'plugins/emoticons_large/icons';
				$this->readDirs($path);
			?>
				
        	
        	<?php
        }
    }
?>
