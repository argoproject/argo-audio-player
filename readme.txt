=== Argo Audio Player ===
Contributors: Project Argo
Tags: audio, audio player 
Requires at least: Only tested with 3.2.1
Tested up to: 3.2.1
Stable tag: 1.0


Installation
=========================
1.) Install the plugin into your /wp-content/plugins directory using one of the following methods
  a.) git clone git@github.com:argoproject/argo-audio-player.git into the plugins directory
  b.) download the argo-audio-player.zip file from the Downloads tab on the github project page and unzip it into your plugins directory
  c.) *FUTURE FEATURE* download from wordpress.org or install using the Wordpress install plugins feature
2.)  Log into your Wordpress admin area, go to Plugins, and click "activate" on the argo-audio-player plugin.

This audio plugin so far supports the following extensions (as supported by the browser/operating system that are being used by the reader)
mp3, mp4, ogg, m4a, wav
Support for other files types may be added in the future.


Using The Plugin
=========================
Once you have activated the plugin, the default "add audio" action (See Screenshot 1) from the posts page will be overridden to insert the below example code into your post:
[audio href="http://[your url here]/wp-content/uploads/2011/11/[your audio file here]" title="[your file title here]"]Insert caption here[/audio]
The audio file path & title will be automatically populated by the plugin (See Screenshot 2), but you are required to replace "Insert caption here" with a caption of your choice.
You may also modify the title if desired.
If any of the other code is modified, the player may not work correctly.
Once the post is published (or previewed), the audio player will show up instead of the above code (See Screenshot 3) on your page and the reader -
will be able to play & pause the audio files.


Known Issues / Troubleshooting Tips
=========================
If two or more of the audio player lines of code are on the same line in the editor, only the first code will be transformed into an audio player.
Please make sure that you insert a line feed / carriage return after each audio file that is inserted.
  

Screenshots
=========================
Screenshot 1:  Adding an audio file using the Media Gallery tab (also available using the From Computer, or From URL tabs)
Screenshot 2:  The code that shows up in the editor when adding an audio file
Screenshot 3:  The display of the audio files on the post page using the argo-audio-player plugin

=Version 1.0=
Initial creation of the plugin
Support for mp3, mp4, m4a, ogg, and wav files
Overriding of the default "Add Audio" functionality in the post editor