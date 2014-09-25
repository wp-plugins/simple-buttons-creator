<?php
if (!class_exists("sqlite")):
	class sqlite {
		private $db;	// New SQLite PDO database object
		public $tableName;	// Initialize table name of the database for the rest of object instance
			// @database Database filename
		function __construct($database, $tableName, $base, $cols) {
			if (empty($tableName)) $tableName = $database;	// If the tableName is not provided, then assume that the table name is the same as the database name
			$this->tableName = $tableName;
			if (!is_dir(dirname(__FILE__) . "/data")) die("Please create a folder named 'data' before continuing.");
				// New PDO class object
			$this->db = new PDO("sqlite:" . dirname(__FILE__) . "/data/" . $database . ".sqlite");
			$this->createTable($base, $cols);
		}
			// createTable Creates a new table in the database if it has not yet been created
			// @detail Specify column details when creating the table
		function createTable($base, $columns) {
			if (!empty($columns)):
				$sql = $this->db->prepare("CREATE TABLE IF NOT EXISTS " . $this->tableName . " ({$base}_id int auto increment, {$columns});");
//			print_r($this->db->errorInfo());		// Uncomment this line to show the errors for the SQL statement.
				$sql->execute();
			endif;
		}
			// update_option This function is SQLite replacement for the same function in the WordPress core. It's used to update or create the option to the SQLite database
			// @name The field_name value
			// @value The field_value value
		function update_option($fields, $where) {
			$records = $this->count_rows($where);
			if ($records == 0):
				$cols = "";
				$dt = "";
				foreach ($fields as $field=>$value):
					$cols .= "'{$field}',";	// Matches the format for the table columns
					$dt .= "'{$value}',";	// Matches the format for the data insertion statement
				endforeach;
					// The following two lines removes the last comma of the last value
				$cols = substr($cols, 0, -1);
				$dt = substr($dt, 0, -1);
				
				$sql = $this->db->prepare("INSERT INTO " . $this->tableName . "({$cols}) VALUES ({$dt})");		// Create a data record in the database if it doesn't have specified record
			else:
				$sets = "";
				foreach ($fields as $field=>$value):
					$sets .= "'{$field}'='{$value}',";
				endforeach;
				$sets = substr($sets, 0, -1);
				$sql = $this->db->prepare("UPDATE " . $this->tableName . " SET {$sets} WHERE {$where}");	// Update the record in the database if it found a record 
			endif;
			$sql->execute();
		}
			// get_option This function is a SQLite replacement for the same function in the WordPress core. It's used to get the record from the database and output it
			// @where The critiria for the search
			// @default The default value if the specified search critiria is not found
		function get_option($col, $where, $default='') {
			$sql = $this->db->query("SELECT * FROM " . $this->tableName . " WHERE " . $where);
			$value = '';	// Initialize the output value
			foreach ($sql->fetchAll() as $option):
				$value = $option[$col];	// the value variable won't be replaced if the search critiria is empty
			endforeach;
			if (empty($value)) $value = $default;	// Assign value to default if the value is empty
			return $value;
		}
		
			// This function returns the number of rows for the SQL statement provided
		function count_rows($where="") {
			$search = '';
			if (!empty($where)) $search = $where;
			$sql = $this->db->prepare("SELECT * FROM " . $this->tableName . $search);		// Read how many existing record there are in the database
			$sql->execute();
			$records = sizeof($sql->fetchAll());
			return $records;
		}
	}
endif;
?>