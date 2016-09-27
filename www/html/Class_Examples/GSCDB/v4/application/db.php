<?php

require 'hidden/dbpassword.php';

// Opens and returns a DB connection
function openDBConnection () {
	global $dbpassword;
	$DBH = new PDO("mysql:host=atr.eng.utah.edu;dbname=GSC12", 
			       'cs4540-software', $dbpassword);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $DBH;
}


// Registers a new user
function registerNewUser ($name, $login, $password, $isAdmin) {
	try {
		$DBH = openDBConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("insert into Users (RealName, Login, PW) values(?,?,?)");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $login);
		$hashedPassword = computeHash($password, makeSalt());
		$stmt->bindValue(3, $hashedPassword);
		$stmt->execute();
		$userid = $DBH->lastInsertId();

		$stmt = $DBH->prepare("insert into Roles (Login, Role) values(?,?)");
		$stmt->bindValue(1, $login);
		$stmt->bindValue(2, "user");
		$stmt->execute();

		if ($isAdmin) {
			$stmt = $DBH->prepare("insert into Roles (Login, Role) values(?,?)");
			$stmt->bindValue(1, $login);
			$stmt->bindValue(2, "admin");
			$stmt->execute();
		}
		$DBH->commit();
		return true;
	}
	catch (PDOException $e) {
		if ($e->getCode() == 23000) {
			return false;
		}
		reportDBError($e);
	}
}


	
// Returns the options for the cookie menu
function getCookieTypes () {
	try {   
        $DBH = openDBConnection();
        $stmt = $DBH->prepare("select CookieKey, CookieName from Cookies"); 
        $stmt->execute();
        $cookieTypes = array();
        while ($row = $stmt->fetch()) {
        	$cookieTypes[$row['CookieKey']] = $row['CookieName'];
        }
        return $cookieTypes;
    }
    catch (PDOException $e) { 
    	reportDBError($e); 
    }  
}


// Returns name that goes with the login name, or NULL if login name unknown
function getRealName ($loginName) {
	try {
		$DBH = openDBConnection();
		$stmt = $DBH->prepare("select RealName from Users where Login=?");
		$stmt->bindValue(1, $loginName);
		$stmt->execute();
		if ($row = $stmt->fetch()) {
			return $row['RealName'];
		}
		else {
			return NULL;
		}
	}
	catch (PDOException $e) {
		reportDBError($e);
	}
}


// Records an order to the DB
function placeOrder ($userid, $shoppingCart) {

	try {

		// Open handle and start transaction
		$DBH = openDBConnection();
		$DBH->beginTransaction();
		
		// Record name and address for this order
		$stmt = $DBH->prepare("insert into Orders (UserID) values(?)");
		$stmt->bindValue(1, $userid);
		$stmt->execute();

		// Recover ID for new order
		$orderNum = $DBH->lastInsertId();

		// Save the varieties that were ordered into the DB
		foreach ($shoppingCart as $key => $quantity) {
			$stmt = $DBH->prepare("insert into OrderInfo (OrderNum, CookieKey, Quantity) values(?,?,?)");
			$stmt->bindValue(1, $orderNum);
			$stmt->bindValue(2, $key);
			$stmt->bindValue(3, $quantity);
			$stmt->execute();
		}

		// Commit the transaction
		$DBH->commit();

	}
	catch (PDOException $e) {
		$DBH->rollback();
		reportDBError($e);
	}
}


// Returns an array of all the orders in the DB.
// OrderNum => {name => RealName, cart => ShoppingCart, date => ShipmentDate}
function &getAllOrders ($shippedOrders) {

	$allOrders = Array();
	
	try {   
    	$DBH = openDBConnection();
    	$DBH->beginTransaction();
    	if ($shippedOrders) {
    		$stmt = $DBH->prepare("select Orders.OrderNum, RealName, Date from Orders, Users, Shipments where " .
    				"   Orders.UserID = Users.UserID and Orders.OrderNum = Shipments.OrderNum");
    	}
    	else {
	    	$stmt = $DBH->prepare("select OrderNum, RealName from Orders, Users where " .
	    			              "   Orders.UserID = Users.UserID " . 
	    	                      "   and OrderNum not in (select OrderNum from Shipments)");
    	}
    	$stmt->execute();
        
    	$results = $stmt->fetchAll();
    	foreach ($results as $row) {
    		$orderNum = $row['OrderNum'];
    		$name = $row['RealName'];
    		
    		$stmt2 = $DBH->prepare("select CookieKey, Quantity from OrderInfo where OrderNum = ?");
    		$stmt2->bindValue(1, $orderNum);
    		$stmt2->execute();
    		$allItems = array();
    		while ($row2 = $stmt2->fetch()) {
    			$cookieName = $row2['CookieKey'];
    			$quantity = $row2['Quantity'];
    			$allItems[$cookieName] = $quantity;
    		}
    		
    		$allOrders[$orderNum] = array('name' => $name, 'cart' => $allItems);
    		if ($shippedOrders) {
    			$allOrders[$orderNum]['date'] = $row['Date'];
    		}
    	}
    	$DBH->commit();
    	return $allOrders;
    }
	catch (PDOException $e) { 
		$DBH->rollback();
		reportDBError($e);
	} 
}


// Records that an order has been shipped
function shipOrder ($orderNum) {
	
	try {

		// Open handle
		$DBH = openDBConnection();

		// Record name and address for this order
		$stmt = $DBH->prepare("insert into Shipments (OrderNum, Date) values(?,?)");
		$stmt->bindValue(1, $orderNum);
		$stmt->bindValue(2, date("Y-m-d H:i:s"));
		$stmt->execute();

	}
	catch (PDOException $e) {
		reportDBError($e);
	}
}


// Logs and reports a database error
function reportDBError ($exception) {
	$file = fopen("application/log.txt", "a"); 
	fwrite($file, date(DATE_RSS));
	fwrite($file, "\n");
	fwrite($file, $exception->getMessage());
	fwrite($file, $exception->getTraceAsString());
	fwrite($file, "\n");
	fwrite($file, "\n");
	fclose($file);
	require "views/error.php";
	exit();
}

?>