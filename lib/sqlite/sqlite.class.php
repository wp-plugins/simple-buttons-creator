<?php

if (class_exists("sqlite")):		// In order to prevent the class to be included multiple times

	$sqlite = new ReflectionClass("sqlite");	
	$sqlite_current = $sqlite->getFileName();
	
	if (filemtime(__FILE__) > filemtime($sqlite_current)):	// Replace the current class with the class in this file if it is newer than the current defined class
		$new_sqlite = file_get_contents(__FILE__);
		file_put_contents($sqlite_current, $new_sqlite);
	endif;

else:

	class sqlite {

		private $db;
		public $tableName;

		function __construct($filePath, $fileName, $tableName='') {
			if (!file_exists($filePath)) mkdir($filePath, 0777, true);
			if (empty($tableName)) $tableName = $fileName;
			$this->tableName = $tableName;
			$this->db = new PDO("sqlite:" . $filePath . "/" . $fileName . ".sqlite");
			$this->createTable();
		}

		function createTable() {
			$sql = $this->db->prepare("CREATE TABLE IF NOT EXISTS " . $this->tableName . " (id INTEGER PRIMARY KEY AUTOINCREMENT, setting VARCHAR(255), value TEXT, group_id INTEGER)");
//			print_r($this->db->errorInfo());		// Uncomment this line to show the errors for the SQL statement.
				$sql->execute();
		}
		/**
		  * This function is SQLite replacement for the same function in the WordPress core. It's used to update or create the option in the SQLite database
		  * @setting The field_name value
		  * @value The field_value value
		  * @group This is an optional variable. It can be used when there are same settings but different values, such as personal records for each person's name.
		  */
		function update_option($setting, $value, $group='1') {
			$records = $this->count_rows("setting='{$setting}' AND group_id={$group}");
			if ($records == 0):
				$sql = $this->db->prepare("INSERT INTO " . $this->tableName . "(setting, value, group_id) VALUES ('{$setting}', '{$value}', {$group})");		// Create a data record in the database if it doesn't have specified record
			else:
				$sql = $this->db->prepare("UPDATE " . $this->tableName . " SET value='{$value}'  WHERE setting='{$setting}' AND group_id={$group}");	// Update the record in the database if it found a record 
			endif;
			$sql->execute();
		}
		/**
		  * This function is a SQLite replacement for the same function in the WordPress core. It's used to get the record from the database and output it
		  * @setting The setting critiria for the search
		  * @default The default value if the specified search critiria is not found
		  */
		function get_option($setting, $default='', $group='1') {
			$sql = $this->db->query("SELECT * FROM " . $this->tableName . " WHERE setting='{$setting}' AND group_id={$group}");
			$value = '';
			foreach ($sql->fetchAll() as $option):
				$value = $option['value'];	// the value variable won't be replaced if the search critiria is empty
			endforeach;
			if (empty($value)) $value = $default;	// Assign value to default if the value is empty
			return $value;
		}
		
			// This function returns the number of rows for the SQL statement provided
		function count_rows($where="") {
			$search = '';
			if (!empty($where)) $search = " WHERE " . $where;
			$sql = $this->db->prepare("SELECT * FROM " . $this->tableName . $search);		// Read how many existing record there are in the database
			$sql->execute();
			$records = sizeof($sql->fetchAll());
			return $records;
		}
	
			// This function deletes the specified data in the database
		function remove_option($option, $id='1') {
			$search = (!empty($option)) ? "setting='{$option}' AND group_id={$id}" : "group_id={$id}";
			$sql = $this->db->prepare("DELETE FROM " . $this->tableName . " WHERE " . $search);
			$sql->execute();
		}
		
			// This function returns the group_id column as an array
		function show_id($unique) {
			$sql = $this->db->prepare("SELECT group_id FROM " . $this->tableName . " WHERE setting='{$unique}'");
			$sql->execute();
			$group_id['empty'] = "0";
			foreach ($sql->fetchAll() as $query):
				if (isset($group_id['empty']) && $group_id['empty'] == "0"):
					array_pop($group_id);
				endif;
				$group_id[] = $query['group_id'];
			endforeach;
			return $group_id;
		}
		
	}
		
endif;
?>