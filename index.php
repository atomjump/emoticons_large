<?php
    include_once("classes/cls.pluginapi.php");

    class plugin_emoticons_large
    {
    	/*
        public function before_message($message)
        {
            global $root_server_url;
            
            //Do your thing in here. Here is a sample.
            $api = new cls_plugin_api();
            
            if(strpos($message, 'large-emoticon') !== false) {
                $message = str_replace("large-emoticon", '<img width="16" height="16" src="' . $root_server_url . '/plugins/emoticons_basic/img/smiley.png">', $message);
            }
            
            
			
            //e.g. hide the message we have just posted if it includes the string 'aargh' in it.
            if(strpos($message, ':)') !== false) {
                $message = str_replace(":)", '<img width="16" height="16" src="' . $root_server_url . '/plugins/emoticons_basic/img/smiley.png">', $message);
            }
            
            if(strpos($message, ';)') !== false) {
                $message = str_replace(";)", '<img width="16" height="16" src="' . $root_server_url . '/plugins/emoticons_basic/img/wink.png">', $message);
            }
            
            if(strpos($message, ':(') !== false) {
                $message = str_replace(":(", '<img width="16" height="16" src="' . $root_server_url . '/plugins/emoticons_basic/img/sad.png">', $message);
            }
            
             if(strpos($message, 'lol') !== false) {
                $message = str_replace("lol", '<img width="16" height="16" src="' . $root_server_url . '/plugins/emoticons_basic/img/lol.png">', $message);
            }
            

            return $message;

        }
        */
        
        public function on_upload_screen()
        {
        	global $root_server_url;
        	//sender_name_str
        	?>
        	<script>
        		function insertEmoticon(url)
        		{
        			
					var data = $('#comment-input-frm').serialize();
					data = data + "&icon=<?php echo $root_server_url ?>/plugins/emoticons_large/icons/" + url;
	
	
					alert(JSON.stringify(data));		//TEMPORARY TESTING
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
        	
        	<a href="javascript:" onclick="return insertEmoticon('sample-set/pirate.jpg');"><img src="<?php echo $root_server_url ?>/plugins/emoticons_large/icons/sample_set/pirate.jpg"></a>	
        	
        	<?php
        
        }
    }
?>