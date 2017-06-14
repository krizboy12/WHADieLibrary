<?php
	require 'sqlHandler.php';

	$table = $_POST["table"];

		/*
			to add more fields, create a new input on the html form and give it a 
				name attribute. Make sure the name in the form matches the column names
				in the sql database
		*/

	$unwantedFields = [ "table", "function", "dieID" ];

	// maybe add if function = add, continue, else update

	foreach ($_POST as $col => $value) {
		// avoid sending unwanted data
		if (in_array($col, $unwantedFields))
			continue;
		
		$cols[] = $col;
		$values[] = $value;
	}
	
		/*
			Create new database object, setEcho on for error messages, connect to it,
				insert using the prepped variables, and disconnect once we have the data
		*/
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB'); 
	$db->setEcho(1);
	$db->connect();

	// adding new entry or editing an existing one
	$function = $_POST['function'];

	if ($function == "add")
		$db->insert($table, $values, $cols);
	else if ($function == "edit") {
		$where = "dieID";
		$in = $_POST["dieID"];
		$db->update($table, $values, $cols, $where, $in);
	}

	$db->disconnect();
?>