<?php

include './cloudinary/Cloudinary.php';
include './cloudinary/Uploader.php';
include './cloudinary/Api.php';
include './cloudinary/Error.php';

class UploadToCloudinary{

	public $target_dir = "./cloudinary/temp/";
	public $uploadSuccessfully = false;
	public $Message = "No Message";
	public $CloudinaryResult = null;
		
	function __construct()    {
		\Cloudinary::config(array( 
		  "cloud_name" => "tradingjournal", 
		  "api_key" => "164457864928417", 
		  "api_secret" => "WhfvkEl8xD9zbVdo-jidQsTlTUc" 
		));
						
	}
	
	function Delete($id)  {
		\Cloudinary\Uploader::destroy($id);
	}
	
	function UploadNowV3($inputName)  {		
				
		$target_file = $target_dir . $_SESSION['UserGUID'].'_'.uniqid().'_'.uniqid().'.'.strtolower(pathinfo($_FILES[$inputName]["name"],PATHINFO_EXTENSION));
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES[$inputName]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
		        $this->Message = "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    $this->Message = "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES[$inputName]["size"] > 3145728) {
		    $this->Message = "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    $this->Message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    
		} else {
		    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
		        $cloudinaryResult = \Cloudinary\Uploader::upload($target_file, array(
		            "unique_filename" => false,
		            "use_filename" => true,
		            "folder" => "ProductionV2",
		    	));
		    	$this->CloudinaryResult = $cloudinaryResult; 	
		    	if (isset($cloudinaryResult["signature"]) && isset($cloudinaryResult["secure_url"])){		    		    	
		        	unlink($target_file);
		    	}
		        
		    } else {
		        $this->Message = "Sorry, there was an error uploading your file.";

		    }
		}
		
		$this->uploadSuccessfully = $uploadOk;

	}
	
	function UploadNowV2($inputName, $index)  {		
				
		$target_file = $target_dir . $_SESSION['UserGUID'].'_'.uniqid().'_'.uniqid().'.'.strtolower(pathinfo($_FILES[$inputName]["name"][$index],PATHINFO_EXTENSION));
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		
		$check = getimagesize($_FILES[$inputName]["tmp_name"][$index]);
		if($check !== false) {
		    $uploadOk = 1;
		} else {
		    $this->Message = "File is not an image.";
		    $uploadOk = 0;
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
		    $this->Message = "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES[$inputName]["size"][$index] > 3145728) {
		    $this->Message = "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    $this->Message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    
		} else {
		    if (move_uploaded_file($_FILES[$inputName]["tmp_name"][$index], $target_file)) {
		        $cloudinaryResult = \Cloudinary\Uploader::upload($target_file, array(
		            "unique_filename" => false,
		            "use_filename" => true,
		            "folder" => "ProductionV2",
		    	));
		    	$this->CloudinaryResult = $cloudinaryResult; 	
		    	if (isset($cloudinaryResult["signature"]) && isset($cloudinaryResult["secure_url"])){		    		    	
		        	unlink($target_file);
		    	}
		        
		    } else {
		        $this->Message = "Sorry, there was an error uploading your file.";

		    }
		}
		
		$this->uploadSuccessfully = $uploadOk;

	}
	
	function UploadNow($inputName)  {		
				
		$target_file = $target_dir . $_SESSION['UserGUID'].'_'.uniqid().'_'.uniqid().'.'.strtolower(pathinfo($_FILES[$inputName]["name"],PATHINFO_EXTENSION));
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES[$inputName]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
		        $this->Message = "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    $this->Message = "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES[$inputName]["size"] > 3145728) {
		    $this->Message = "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    $this->Message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    
		} else {
		    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
		        $cloudinaryResult = \Cloudinary\Uploader::upload($target_file, array(
		            "unique_filename" => false,
		            "use_filename" => true,
		            "folder" => "ProductionV2",
		    	));
		    	$this->CloudinaryResult = $cloudinaryResult; 	
		    	if (isset($cloudinaryResult["signature"]) && isset($cloudinaryResult["secure_url"])){		    		    	
		        	unlink($target_file);
		    	}
		        
		    } else {
		        $this->Message = "Sorry, there was an error uploading your file.";

		    }
		}
		
		$this->uploadSuccessfully = $uploadOk;

	}
}

?>