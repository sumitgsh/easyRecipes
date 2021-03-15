<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');
require_once("./includes/storage.php");

class Photograph {
	
	protected static $table_name="photograps";
	protected static $db_fields=array('id','filename', 'type', 'size');
	public $id;
	public $filename="sam.jpg";
	public $type;
	public $size;
	public $firebasefilepath="No-Image-Found";

	private $temp_path;
	public $errors=array();
	
  protected $upload_errors = array(
	   UPLOAD_ERR_OK 				=> "No errors.",
	  UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		=> "No file.",
	  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);


	// Pass in $_FILE(['uploaded_file']) as an argument

  public function attach_file($file) {

		// Perform error checking on the form parameters

		if(!$file || empty($file) || !is_array($file)) {
		  // error: nothing uploaded or wrong argument usage
		  $this->errors[] = "No file was uploaded.";
		  return false;
		} elseif($file['error'] != 0) {
		  // error: report what PHP says went wrong
		  $this->errors[] = $this->upload_errors[$file['error']];
		  return false;
		} else {
			// Set object attributes to the form parameters.
		  $this->temp_path  = $file['tmp_name'];
		  $this->filename   = random_int(-999, 999).basename($file['name']);
		  $this->type       = $file['type'];
		  $this->size       = $file['size'];
			// Don't worry about saving anything to the database yet.
			return true;

		}
	}
  
	public function save() {
		// A new record won't have an id yet.

		if(isset($this->id)) {
			// Really just to update the caption
			$this->update();
		} else {
			// Make sure there are no errors
			
			// Can't save if there are pre-existing errors
		  if(!empty($this->errors)) { return false; }
		  
			
		  // Can't save without filename and temp location
		  if(empty($this->filename) || empty($this->temp_path)) {
		    $this->errors[] = "The file location was not available.";
		    return false;
		  }
			
		// 	// Determine the target_path
		//   $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;
		  
		  // Make sure a file doesn't already exist in the target location

		  if(file_exists($target_path)) {
		    $this->errors[] = "The file {$this->filename} already exists.";
		    return false;
		  }
		
			// Attempt to move the file to cloud
			# The name for the bucket
			$buckets=new storage();
			$bucketName = 'easyrecipestorage.appspot.com';

		    $buckets=$buckets->uploadObject($bucketName,$this->filename,$this->temp_path);
		
			// if(move_uploaded_file($this->temp_path, $target_path)) 
			// {
		  	// Success
				// Save a corresponding entry to the database
				if($this->create()) {
					// We are done with temp_path, the file isn't there anymore
					unset($this->temp_path);
					return true;
				// }
			} else {
				// File was not moved.
		    $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
		    return false;
			}
		}
	}
	public function destroy(){
		//First remove the database entry
		if($this->delete()){
			//then remove the file
			$target_path=SITE_ROOT.DS.'public'.DS.$this->image_path();
			
			return unlink($target_path)? true:false;
		
	}else
		{
			//database delete failed
			return false;
		}
		//then remove the file

	}
	public function image_path(){
		return 'https://storage.cloud.google.com/easyrecipestorage.appspot.com/'.$this->filename;
	}
	public function contribute($id=0){
		
		return Contribution::find_contributions_on($this->id);
	}
	public function size_as_text(){
		if($this->size<1024){
			return "{$this->size}bytes";
		}elseif($this->size<1048576){
			$size_kb=round($this->size/1024);
			return "{$size_kb}KB";
		}else{
			$size_mb=round($this->size/1048576,1);//1 decimal place
			return "{$size_mb}MB";
		}
	}
	
	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
   public static function find_by_id($id=0) {
	  global $database;
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
     global $database;
     $result_set = $database->query($sql);
     $object_array = array();
     while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  public static function count_all(){
  	global $database;
  	$sql="SELECT COUNT(*)  AS total FROM ".self::$table_name;
  	$result_set=$database->query($sql);
  	$row=$database->fetch_array($result_set);
  	$num_rows = $row['total']; 

  	return  $num_rows; 
  }

	private static function instantiate($record) {
		// Could check that $record exists and is an array
     $object = new Photograph();
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  //$this->attributes()  is an array
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	// replaced with a custom save()
	// public function save() {
	//   // A new record won't have an id yet.
	//   return isset($this->id) ? $this->update() : $this->create();
	// }
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		if($attributes["id"]==""){
            array_shift($attributes);
        }
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}
	
	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	   return true;
	 // return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

}

?>