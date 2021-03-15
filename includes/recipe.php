
<?php 

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');
class Recipe
{
    protected static $table_name="recipe";
	protected static $db_fields = array('user_Id', 'uName', 'Title', 'Description','Servings','CookingTime','Ingredients','Direction');
	
	public $user_Id;
	public $uName;
	public $Title;
	public $Description;
	public $Servings;
	public $CookingTime;
    public $Ingredients;
    public $Direction;


    //Receiving recipe details
    public function addRecipe($recipeData) {

        //Initialize all the recipe details values
        $this->user_Id=$recipeData[0];
        $this->uName=$recipeData[1];
        $this->Title=$recipeData[2];
        $this->Description=$recipeData[3];
        $this->Servings=$recipeData[4];
        $this->CookingTime=$recipeData[5];
        $this->Ingredients=$recipeData[6];
        $this->Direction=$recipeData[7];
       
				if($this->create()) {
                    return true;
				}
		     else {
				// Recipe details cant be saved
		         return false;
			    }
				return true;
    }
	
	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
   public static function find_Recipe_by_id($id=0) {
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
  

	private static function instantiate($record) {
		// Could check that $record exists and is an array
     $object = new Recipe();
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
	
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    return true;
	  } else {
	    return false;
	  }
	}

}

?>