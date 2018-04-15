<?php
$settingsDirectory = "../settings";
if (!is_dir($settingsDirectory)) {
    mkdir($settingsDirectory);
}
$lockingFile = $settingsDirectory."/EMG.lock";
if (!file_exists($lockingFile)){
	fclose(fopen($lockingFile, "w"));
	$myfile = fopen($settingsDirectory."/EMG.txt", "r")  or die("Unable to open file!");
	$contents = fread($myfile, filesize($settingsDirectory."/EMG.txt"));
  echo($contents);
	fclose($myfile);
	unlink($settingsDirectory."/EMG.lock");
}

?>
