What is PHP-Directory-Backup?
========================
PHP-Directory-Backup is a simple PHP backup script which generates a zip file of your directories and uploads it to a remote ftp server.

How to use
========================
Just place the index.php file in any directory of your webserver and edit the configuration values at the start of the file. You MUST change the configuration options to match your server settings otherwise the script will fail and not generate the backup. This script has only been tested on dedicated servers and VPS's, it may or may not work on shared hosting because it depends on having the correct permissions to create the backup file.

The script is designed to be run either by loading the script in a browser or by setting a cron job to run the script every so often.

Use this script at your own risk because it was hacked together by myself many years ago. I've only left it online as a reference.
