<?php
/* AutoBackup PHP Settings - Please edit these to suit your FTP server otherwise the script won't work. */  

$backupdirectory = 'THE DIRECTORY YOU WANT TO BACKUP'; //The directory on your webserver that you want to backup relative to server root.
$ftp_server = "ADDRESS OF REMOTE FTP SERVER "; // The IP Address/URL of your FTP backup server
$ftp_username = "FTP USERNAME";     //The username that you use to connect to your FTP Server
$ftp_password = "FTP PASSWORD"; //The password that you use to connect to your FTP Server
$remotedirectory = "REMOTE DIRECTORY (WITH TRAILING SLASH)"; //The remote directory you want to store your backups in, relative to ftp root

/* End Autobackup PHP Settings, don't touch anything below here */

$timestamp = date("H.i.s - m,d,y"); //The format of time and date that is used to name the file
$ext = ".zip";             // The extension of the file created (must be left to .zip)
$filename = $timestamp.$ext; //The concatenation of the time/date stamp and file extension
$source_file = $filename;
$destination_file = $remotedirectory.$filename;
ini_set('max_execution_time', 300); //Increase the script execution time in case of a big backup (300 seconds = 5 minutes)

Zip ($backupdirectory, $filename);   //This calls the zip function and starts the script

function Zip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', realpath($file));

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}
echo "Successfully created the backup, uploading to FTP server now...<br><br>";

//set up basic connection
$connection_id = ftp_connect($ftp_server);

//login wih username and password
$login_result = ftp_login($connection_id, $ftp_username, $ftp_password);

//check connection
if ((!$connection_id) || (!$login_result)) {
	    echo "FTP Connection has failed! <br>";
		echo "Attempted to connect to $ftp_server for user $ftp_username <br>";
		exit;
} else {
	echo "Connected to $ftp_server, for user $ftp_username <br>";
}

//upload the file 
$upload = ftp_put ($connection_id, $destination_file, $source_file, FTP_BINARY);

//check upload status
if (!$upload) {
	echo "FTP upload has failed <br>";
} else {
	echo "Uploaded $source_file to $ftp_server as $destination_file <br>";
}

//close the FTP stream
ftp_close ($connection_id);		

$file = $filename;
$unlink = unlink($file);
if ($unlink == TRUE) {
	echo 'Cleanup Successful!';
}
?>