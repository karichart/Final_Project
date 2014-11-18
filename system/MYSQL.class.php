<?php

class MYSQL
{
    private static $instance;
	private static $connection;
	
	
	private static $host = '127.0.0.1';
	private static $username = 'root';
	private static $password = 'NEWPASSWORD';
	private static $database = 'final_project';
	
	
	/*
	private static $host = 'earth.cs.utep.edu';
	private static $username = 'wb_karichart';
	private static $password = 'r1ch4r7!';
	private static $database = 'wb_karichart';
	**/
    private function __construct()
    {
        self::$connection = @new mysqli(self::$host, self::$username, self::$password, self::$database);
		if(self::$connection->connect_error)	//If the connection could not be defined
		{	echo "<h1>Could not connect to the database</h1><p>" . self::$connection->connect_error . "</p>";
			exit();
		}
    }

     static function query($query)
    {
        if(!isset(self::$instance)) 
    	self::$instance = new MYSQL(); 	
       

    	$set = self::$connection->query($query); 
        
    	if( !empty(self::$connection->error))
    	{	echo self::$connection->error;}
		
    	return $set;
    }

     static function error()
    { return self::$connection->error;    }

    
     static function sanitize($string)
    {
	    if(!isset(self::$instance)) #If instance has not been created, then do it.
	    	{	self::$instance = new MYSQL();   	}


		return self::$connection->real_escape_string(htmlentities(strip_tags(stripslashes($string))));
    }

	 static function multiQuery($query){
		if(!isset(self::$instance)) 
    	self::$instance = new MYSQL(); 	
       

    	$set = self::$connection->multi_query($query); 
        
    	if( !empty(self::$connection->error))
    	{	echo self::$connection->error;}
		
    	return self::$connection->store_result();
	}
	
     static function affected_rows()
    {	return self::$connection->affected_rows;   }
	
	 static function last_id() {
      	return self::$connection->insert_id;
    }
    
}
?>