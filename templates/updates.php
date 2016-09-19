<h2 class="sub-header">Updates <span class="pull-right"><small><?= 'V'.file_get_contents( __dir__ . '/../config/currentVersion.txt'); ?></small></span></h2>

<?php
ini_set('max_execution_time',-1); // Consider setting to -1? Otherwise, with this simple software, it shouldn't be an issue.
error_reporting(0);


$update_server = 'http://update-villnoweric.c9users.io/server/';
$update_program = 'siso';

//Check for an update. We have a simple file that has a new release version on each line. (1.00, 1.02, 1.03, etc.)
if(!file_get_contents($update_server . $update_program . '/release.php')){
    die ('<div class="alert alert-danger"><b>Error:</b> Server Connection Failed - Make sure you and the server are online and/or try again later.</div>');
}else{
$getVersions = file_get_contents($update_server . $update_program . '/release.php');
}
if ($getVersions != '')
{
    //If we managed to access that file, then lets break up those release versions into an array.
    $versionList = explode("n", $getVersions);    
    foreach ($versionList as $aV)
    {
        if ( $aV > file_get_contents( __dir__ . '/../config/currentVersion.txt')) {
            
            echo '<div class="alert alert-warning"><b>Important:</b> Before updating, please back up your database and files. For help with updates, visit the <a href="/help/updating">Updating SISO</a> help page.</div>';
            echo '<div class="alert alert-info">New Update Found: V'.$aV.'</div>';
            
            $found = true;
           
            //Download The File If We Do Not Have It
            if ( !is_file( __dir__ . '/../UPDATES/'.$aV.'.zip' )) {
                echo '<div class="alert alert-info">Downloading New Update</div>';
                $newUpdate = file_get_contents($update_server . $update_program .'/' . $aV . '.zip');
                if ( !is_dir(__dir__ . '/../UPDATES') ) mkdir (__dir__ . '/../UPDATES', 0777);
                $dlHandler = fopen(__dir__ . '/../UPDATES/'.$aV.'.zip', 'w');
                if ( !fwrite($dlHandler, $newUpdate) ) { echo '<div class="alert alert-danger">Could not save new update. Operation aborted.</div>'; exit(); }
                fclose($dlHandler);
                echo '<div class="alert alert-info">Update Downloaded And Saved</div>';
            } else echo '<div class="alert alert-info">Update already downloaded.</div>';    
           
            if ($_GET['doUpdate'] == true) {
                //Open The File And Do Stuff
                $zipHandle = zip_open( __dir__ . '/../UPDATES/'.$aV.'.zip');
                echo '<ul>';
                while ($aF = zip_read($zipHandle) )
                {
                    $thisFileName = zip_entry_name($aF);
                    $thisFileDir = dirname($thisFileName);
                   
                   echo $thisFileName . '<br>';
                   echo $thisFileName . '<br><br>';
                   
                    //Continue if its not a file
                    if ( substr($thisFileName,-1,1) == '/') continue;
                   
    
                    //Make the directory if we need to...
                    if ( !is_dir ( __dir__ . '/../'.$thisFileDir ) )
                    {
                         mkdir ( __dir__ . '/../'.$thisFileDir );
                         echo '<li>Created Directory '.$thisFileDir.'</li>';
                    }
                   
                    //Overwrite the file
                    if ( !is_dir( __dir__ . '/../'.$thisFileName) ) {
                        echo '<li>'.$thisFileName.'...........';
                        $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                        $contents = str_replace("rn", "n", $contents);
                        $updateThis =  fopen($thisFileName,'w');
                       
                        //If we need to run commands, then do it.
                        if ( $thisFileName == 'upgrade.php' )
                        {
                            $upgradeExec = fopen ('upgrade.php','w');
                            fwrite($upgradeExec, $contents);
                            fclose($upgradeExec);
                            include ('upgrade.php');
                            unlink('upgrade.php');
                            echo' EXECUTED</li>';
                        }
                        else
                        {
                            fwrite($updateThis, $contents);
                            fclose($updateThis);
                            unset($contents);
                            echo' UPDATED</li>';
                        }
                    }
                }
                echo '</ul>';
                $updated = TRUE;
            }
            else echo '<p><a href="?doUpdate=true" class="btn btn-success">Update Now</a></p>';
            break;
        }
    }
    
    if ($updated == true)
    {
        echo '<div class="alert alert-success">SISO Updated to V'.$aV.'</div>';
    }
    else if ($found != true) echo '<div class="alert alert-success">You are all up to date!</div>';

    
}
else echo '<p>Could not find latest realeases.</p>';