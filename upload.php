<?php
if ($_FILES && $_FILES['zipfiles']) {
    
    if (!empty($_FILES['zipfiles']['name'][0])) {
        
        $zip = new ZipArchive();
        $zip_name = "uploads/files/upload_" .$aid. ".zip";
        
        // Create a zip target
        if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
            $error .= "Sorry ZIP creation is not working currently.<br/>";
        }
        
        $imageCount = count($_FILES['zipfiles']['name']);
        for($i=0;$i<$imageCount;$i++) {
        
            if ($_FILES['zipfiles']['tmp_name'][$i] == '') {
                continue;
            }
            $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
            
            // Moving files to zip.
            $zip->addFromString($_FILES['zipfiles']['name'][$i], file_get_contents($_FILES['zipfiles']['tmp_name'][$i]));
            
            // moving files to the target folder.
            $uploads = move_uploaded_file($_FILES['zipfiles']['tmp_name'][$i], './uploads/files/' . $newname);
        }
        $zip->close();
		if(isset($uploads)){
			$this->conn->query("UPDATE archive_list set `folder_path` = CONCAT('{$zip_name}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$aid}' ");
		}
        
        // Create HTML Link option to download zip
        //$success = basename($zip_name);
    } else {
        $error = '<strong>Error!! </strong> Please select a file.';
    }
}


if(isset($uploads)){
						$this->conn->query("UPDATE archive_list set `folder_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$aid}' ");
					}


//if ($isset($_FILES['zipfiles']) && $_FILES['zipfiles'] !='') {
				if (isset($_FILES['zipfiles'])) {
					$zip = new ZipArchive();
					$zip_name = "uploads/files/upload_" .$aid. ".zip";
					$folder_path =base_app. $zip_name;
					$upload = $_FILES['zipfiles']['tmp_name'];
					
					

					// Create a zip target
					if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
					$error .= "Sorry ZIP creation is not working currently.<br/>";
					}

					$imageCount = count($_FILES['zipfiles']['name']);
					for($i=0;$i<$imageCount;$i++) {
						if ($_FILES['zipfiles']['tmp_name'][$i] == '') {
							continue;
						}
						$newname = date('YmdHis', time()) . mt_rand() . '.jpg';

						// Moving files to zip.
						$zip->addFromString($_FILES['zipfiles']['name'][$i], file_get_contents($_FILES['zipfiles']['tmp_name'][$i]));

						// moving files to the target folder.
						$uploads = move_uploaded_file($_FILES['zipfiles']['tmp_name'][$i], $folder_path);
					}
					if(isset($uploads)){
						$this->conn->query("UPDATE archive_list set `folder_path` = CONCAT('{$zip_name}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$aid}' ");
					}
					$zip->close();
					

					// Create HTML Link option to download zip
					//$success = basename($zip_name);
				} /*else {
				$error = '<strong>Error!! </strong> Please select a file.';
				}*/
				//}
				
				
				
				
				if (isset($_FILES['zipfiles'])) {
					$zip         = new ZipArchive();          // Load zip library 
					$zip_name = "uploads/files/upload_" .$aid. ".zip";
					//$zip_name    = "upload/" . time() . ".zip";       // Zip name
					$folder_path =base_app. $zip_name;
					$upload = $_FILES['zipfiles']['tmp_name'];
					
					if($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
						//Opening zip file to load files
						$error .= "* Sorry ZIP creation failed at this time<br/>";
					}
					if(is_array($_FILES['zipfiles']['tmp_name'])) {
						// multi file form
						foreach($_FILES['zipfiles']['tmp_name'] as $k => $value) {
							if($value == '') { // not empty field
								continue;
							}
							$zip->addFromString($_FILES['zipfiles']['name'][$k], file_get_contents($value));
							$uploads = move_uploaded_file($_FILES['zipfiles']['tmp_name'][$k], $folder_path);
						}
					} elseif($_FILES['zipfiles']['tmp_name'] != '') { // not empty field
						// single file form
						$zip->addFromString($_FILES['zipfiles']['name'], file_get_contents($_FILES['zipfiles']['tmp_name']));
						// moving files to the target folder.
						$uploads = move_uploaded_file($_FILES['zipfiles']['tmp_name'], $folder_path);
					}
					if(isset($uploads)){
						$this->conn->query("UPDATE archive_list set `folder_path` = CONCAT('{$zip_name}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$aid}' ");
					}
					$zip->close();
				}
				
				
				
				
				
				$upload_errors = array(
UPLOAD_ERR_OK	      => "No errors.",
UPLOAD_ERR_INI_SIZE	  => "Larger than upload_max_filesize.",
UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE.",
UPLOAD_ERR_PARTIAL	  => "Partial upload.",
UPLOAD_ERR_NO_FILE    => "No file.",
UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
UPLOAD_ERR_EXTENSION  => "File upload stopped by extension.",
);
 
if (isset($_POST['submit'])){
	$tmp_file = $_FILES['upload_file']['tmp_name'];
	@$target_file = basename($_FILES['upload_file']['name']);
	$upload_dir = "uploads";
 
	if (move_uploaded_file($tmp_file,$upload_dir."/".$target_file)){
		echo "File uploaded Succesfully";
	}else{
		$error = $_FILES['upload_file']['error'];
$message = $upload_errors[$error];
	}
 
}
 
 
 //check if a file was uploaded
    if (isset($_FILES['zipfiles']) && !empty($_FILES['zipfiles'])) {
        //single file upload
        if (!is_array($_FILES['zipfiles'])) {
            //initialize the ziparchive class
            $zip = new ZipArchive();
            //set the name of our zip archive
            $zip_name = "uploads/files/upload_" .$aid. ".zip";
            //create the new zip archive using the $file_name above
            if ($zip->open($zip_name, ZipArchive::CREATE) === true) {
                //add the file to the archive
                $zip->addFile($_FILES['zipfiles']['tmp_name'], $_FILES['zipfiles']['name']);
                //close the archive
                $zip->close();
            } else {
                echo "Couldn't create Zip Archive";
            }
        }
        //multiple file uploads
        elseif (is_array($_FILES['zipfiles'])) {
            //initialize the ziparchive class
            $zip = new ZipArchive();
            //set the name of our zip archive
             $zip_name = "uploads/files/upload_" .$aid. ".zip";
            //create the new zip archive using the $file_name above
            if ($zip->open($zip_name, ZipArchive::CREATE) === true) {
                //loop through the tmp_name of the files in $_FILES array
                foreach ($_FILES['file']['tmp_name'] as $key => $tmpName) {
                    //the name of the file
                    $file_name = $_FILES['zipfiles']['name'][$key];
                    //add the file
                    $zip->addFile($tmpName, $file_name);
                }
                //close the archive
                $zip->close();
            } else {
                echo "Couldn't create Zip Archive";
            }
        }
    }
 
 
 
 
 if ($_FILES && $_FILES['zipfiles']) {
    
    if (!empty($_FILES['zipfiles']['name'][0])) {
        
        $zip = new ZipArchive();
        $zip_name = getcwd() . "uploads/files/upload_" . $aid . ".zip";
        
        // Create a zip target
        if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
            $error .= "Sorry ZIP creation is not working currently.<br/>";
        }
        
        $imageCount = count($_FILES['zipfiles']['name']);
        for($i=0;$i<$imageCount;$i++) {
        
            if ($_FILES['zipfiles']['tmp_name'][$i] == '') {
                continue;
            }
            $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
            
            // Moving files to zip.
            $zip->addFromString($_FILES['zipfiles']['name'][$i], file_get_contents($_FILES['zipfiles']['tmp_name'][$i]));
            
            // moving files to the target folder.
            move_uploaded_file($_FILES['zipfiles']['tmp_name'][$i], './uploads/' . $newname);
        }
        $zip->close();
        
        // Create HTML Link option to download zip
        $success = basename($zip_name);
    } else {
        $error = '<strong>Error!! </strong> Please select a file.';
    }
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
?>
<html>
	<head>
		<title>upload </title>
	</head>
	<body>
	<?php if(!empty($message)) { echo "<p>{$message}</p>";}?>
	<form action="upload.php" enctype="multipart/form-data" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
		<input type="file" name="upload_file">
		<input type="submit" name="submit" value="Upload">
 
	</form>
	</body>
</html>


