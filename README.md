<img src="https://atomjump.com/images/logo80.png">

__WARNING: this project has now moved to https://src.atomjump.com/atomjump/emoticons_large.git__

# emoticons_large
Large emoticons (full size images) for the AtomJump Messaging Server


## Requirements

AtomJump Messaging Server >= 3.2.3

## Installation

Unzip or git clone into the folder: your-messaging-server/plugins/emoticons_large

```
 cd your-messaging-server/plugins/
 git clone https://src.atomjump.com/atomjump/emoticons_large.git
 cd emoticons_large/config
 cp configORIGINAL.json config.json
 nano config.json
```

Set the 	

```javascript
	"serverPath": "/your/server/path/here/",	//path to your AtomJump Messaging server
	"staging" : true							//true for staging, false for production version of config
```

Add the string "emoticons_large" into your-loop-server/config/config.json plugins array to enable the plugin. e.g. 

     "plugins": [
         "emoticons_large"
      ]
      
      
## Using

Tap on the 'Upload Icon' at the bottom of any Atomjump popup. Scroll down the page to find the available emoticons.
Tap on an emoticon for a new message with that emoticon.

You are free to add further emoticon sets into the 'icons' folder. They should be put into a named subdirectory, which
will automatically be read. Images can be either .jpg or .png.


## Credits
These icons are from Pixabay.com.


#Future

We may want some form of limit on the number of visible icons here, perhaps expanding by subdirectory name.
