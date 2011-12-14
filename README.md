What is BackuPHP?
========================
BackuPHP is a simple PHP backup script which generates a zip file of your directory's and uploads it to a remote ftp server.

How to use
========================
Just place the index.php file in any directory of your webserver and edit the configuration values at the start of the file. You MUST change the configuration options to match your server settings otherwise the script will fail and not generate the backup. This script has only been tested on dedicated servers and VPS's, it may or may not work on shared hosting because it depends on having the correct permissions to create the backup file.

This script is designed to be run either by loading the script in a browser or by setting a cron job to run the script every so often.

I would highly recommend changing the name of the index.php file to something random so people can't DOS your server by loading the script loads of times.

Find out more
=============
I will be adding a wiki for this script soon but I expect that most people should be able to work out how to use this script because all of the configuration options are clearly commented.

If you have any questions or problems, please send me a message on github.