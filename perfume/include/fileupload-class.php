<?php
class uploader {

	var $file;
	var $path;
	var $language;
	var $acceptable_file_types;
	var $error;
	var $errors; 
	var $accepted;
	var $max_filesize;
	var $max_image_width;
	var $max_image_height;


	function uploader ( $language = 'en' ) {
		$this->language = strtolower($language);
		$this->error   = '';
	}
	
	
	function max_filesize($size){
		$this->max_filesize = (int) $size;
	}


	function max_image_size($width, $height){
		$this->max_image_width  = (int) $width;
		$this->max_image_height = (int) $height;
	}
	
	
	function upload($filename='', $accept_type='', $extention='') {
		
		$this->acceptable_file_types = trim($accept_type); 
		
		if (!isset($_FILES) || !is_array($_FILES[$filename]) || !$_FILES[$filename]['name']) {
			$this->error = $this->get_error(0);
			$this->accepted  = FALSE;
			return FALSE;
		}
				
		$this->file = $_FILES[$filename];
		$this->file['file'] = $filename;
		
		if (!isset($this->file['extention'])) $this->file['extention'] = "";
		if (!isset($this->file['type']))      $this->file['type']      = "";
		if (!isset($this->file['size']))      $this->file['size']      = "";
		if (!isset($this->file['width']))     $this->file['width']     = "";
		if (!isset($this->file['height']))    $this->file['height']    = "";
		if (!isset($this->file['tmp_name']))  $this->file['tmp_name']  = "";
		if (!isset($this->file['raw_name']))  $this->file['raw_name']  = "";
				
		if($this->max_filesize && ($this->file["size"] > $this->max_filesize)) {
			$this->error = $this->get_error(1);
			$this->accepted  = FALSE;
			return FALSE;
		}
		
		if(stristr($this->file["type"], "image")) {
			
			$image = getimagesize($this->file["tmp_name"]);
			$this->file["width"]  = $image[0];
			$this->file["height"] = $image[1];
			
			if(($this->max_image_width || $this->max_image_height) && (($this->file["width"] > $this->max_image_width) || ($this->file["height"] > $this->max_image_height))) {
				$this->error = $this->get_error(2);
				$this->accepted  = FALSE;
				return FALSE;
			}
			switch($image[2]) {
				case 1:
					$this->file["extention"] = ".gif"; break;
				case 2:
					$this->file["extention"] = ".jpg"; break;
				case 3:
					$this->file["extention"] = ".png"; break;
				case 4:
					$this->file["extention"] = ".swf"; break;
				case 5:
					$this->file["extention"] = ".psd"; break;
				case 6:
					$this->file["extention"] = ".bmp"; break;
				case 7:
					$this->file["extention"] = ".tif"; break;
				case 8:
					$this->file["extention"] = ".tif"; break;
				default:
					$this->file["extention"] = $extention; break;
			}
		} elseif(!ereg("(\.)([a-z0-9]{3,5})$", $this->file["name"]) && !$extention) {
			switch($this->file["type"]) {
				case "text/plain":
					$this->file["extention"] = ".txt"; break;
				case "text/richtext":
					$this->file["extention"] = ".txt"; break;
				default:
					break;
			}
		} else {
			$this->file["extention"] = $extention;
		}
		
		if($this->acceptable_file_types) {
			if(trim($this->file["type"]) && (stristr($this->acceptable_file_types, $this->file["type"]) || stristr($this->file["type"], $this->acceptable_file_types)) ) {
				$this->accepted = TRUE;
			} else { 
				$this->accepted = FALSE;
				$this->error = $this->get_error(3);
			}
		} else { 
			$this->accepted = TRUE;
		}
		
		return (bool) $this->accepted;
	}


	function save_file($path, $overwrite_mode="3"){
		if ($this->error) {
			return false;
		}
		
		if (strlen($path)>0) {
			if ($path[strlen($path)-1] != "/") {
				$path = $path . "/";
			}
		}
		$this->path = $path;	
		$copy       = "";	
		$n          = 1;	
		$success    = false;	
				
		if($this->accepted) {
			$this->file["name"] = ereg_replace("[^a-z0-9._]", "", str_replace(" ", "_", str_replace("%20", "_", strtolower($this->file["name"]))));
			
			if(stristr($this->file["type"], "text")) {
				$this->cleanup_text_file($this->file["tmp_name"]);
			}
			
			if(ereg("(\.)([a-z0-9]{2,5})$", $this->file["name"])) {
				$pos = strrpos($this->file["name"], ".");
				if(!$this->file["extention"]) { 
					$this->file["extention"] = substr($this->file["name"], $pos, strlen($this->file["name"]));
				}
				$this->file['raw_name'] = substr($this->file["name"], 0, $pos);
			} else {
				$this->file['raw_name'] = $this->file["name"];
				if ($this->file["extention"]) {
					$this->file["name"] = $this->file["name"] . $this->file["extention"];
				}
			}
			
			switch((int) $overwrite_mode) {
				case 1: 
					if (@copy($this->file["tmp_name"], $this->path . $this->file["name"])) {
						$success = true;
					} else {
						$success     = false;
						$this->error = $this->get_error(5);
					}
					break;
				case 2: 
					while(file_exists($this->path . $this->file['raw_name'] . $copy . $this->file["extention"])) {
						$copy = "_copy" . $n;
						$n++;
					}
					$this->file["name"]  = $this->file['raw_name'] . $copy . $this->file["extention"];
					if (@copy($this->file["tmp_name"], $this->path . $this->file["name"])) {
						$success = true;
					} else {
						$success     = false;
						$this->error = $this->get_error(5);
					}
					break;
				default: 
					if(file_exists($this->path . $this->file["name"])){
						$this->error = $this->get_error(4);
						$success     = false;
					} else {
						if (@copy($this->file["tmp_name"], $this->path . $this->file["name"])) {
							$success = true;
						} else {
							$success     = false;
							$this->error = $this->get_error(5);
						}
					}
					break;
			}
			
			if(!$success) { unset($this->file['tmp_name']); }
			return (bool) $success;
		} else {
			$this->error = $this->get_error(3);
			return FALSE;
		}
	}
	
	function get_error($error_code='') {
		$error_message = array();
		$error_code    = (int) $error_code;
		
		switch ( $this->language ) {
			default:
				$error_message[0] = "Nici un fisier incarcat.";
				$error_message[1] = "Marimea fisierului incarcat depaseste marimea maxima admisa. Marimea fisierului incarcat nu poate fi mai mare decat: " . $this->max_filesize/1000 . " KB (" . $this->max_filesize . " bytes).";
				$error_message[2] = "Dimensiunile fisierului incarcat depasesc dimensiunile maxime admise. Dimensiunile fisierului incarcat nu pot fi mai mari decat: " . $this->max_image_width . " x " . $this->max_image_height . " pixeli.";
				$error_message[3] = "Doar fisiere de tipul: " . str_replace("|", " sau ", $this->acceptable_file_types) . " pot fi incarcate.";
				$error_message[4] = "Fisierul '" . $this->path . $this->file["name"] . "' deja exista.";
				$error_message[5] = "Acces interzis. Nu se poate copia la locatia: '" . $this->path . "'";
			break;
		}
		
		$this->errors[$error_code] = $error_message[$error_code];
		
		return $error_message[$error_code];
	}

	function cleanup_text_file($file){
		$new_file  = '';
		$old_file  = '';
		$fcontents = file($file);
		while (list ($line_num, $line) = each($fcontents)) {
			$old_file .= $line;
			$new_file .= str_replace(chr(13), chr(10), $line);
		}
		if ($old_file != $new_file) {
			$fp = fopen($file, "w");
			fwrite($fp, $new_file);
			fclose($fp);
		}
	}

}

?>