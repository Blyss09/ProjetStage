<?php
/*
 * THis class will handle all data retrieval from DB and return an array with all data necessary
*/

class sqlDataLib
{
	// private $pdo;
	private $db;
    private $lib;
    private $lang;
    private $iniObj;
    function __construct($ini)
    {
        global $_db, $lib, $lang,$iniObj;
        $this->db = $_db;
        $this->lib = $lib;
        $this->lang = $lang;
        $this->iniObj = $ini;
        // $this->$pdo=null;
        // print_r($this->lang);
    }


	/*
	 * format data and retrieve in an array format
	*/
	function fetchData($q, $arr = array(), $br = 1)
	{
		if ($br == 1)  $keywords = array("''" => "'", "%" => "%25", "\n" => "<br>");
		else $keywords = array("''" => "'", "%" => "%25");

		if ($this->iniObj->debugSQL) echo "<br>Query => <br>$q <br>";
		// $sql = sql::getInstance();

		$sql = $this->db->Connect();

		if (!$sql) {
			die("Error: Cannot connect to database.");
		} else {
			try {
				$stmt = $sql->prepare($q);
				$stmt->execute($arr);
				$o = $stmt->fetchAll();
				$d['data'] = $o;
				$d['rows'] = count($o);
				if ($this->iniObj->debugSQL) $this->debugError($e, $stmt);
				return ($d);
			} catch (Exception $e) {
				if ($this->iniObj->debugSQL) $this->debugError($e);
				return ($e);
			}
		}
		$this->db->disconnect();
	}

	function fetchOneRow($q, $arr = "", $br = 1)
	{
		$sql = sql::getInstance();
		$stmt = $sql->dbh->prepare($q);
		if ($stmt->execute($arr)) {
			// $o = $stmt->fetch(PDO::FETCH_OBJ); // One record
			$o = $stmt->fetch();
		}
		if ($this->iniObj->debugSQL) {
			echo "<br><pre>";
			print_r($o);
		}
		if ($br == 1)  $keywords = array("''" => "'", "%" => "%25", "\n" => "<br>");
		else $keywords = array("''" => "'", "%" => "%25");
		// return($myArray);
	}

	/* Remove all trailing spaces and set var to UpperCase*/
	function clrSqlVarUpper($var)
	{

		return addslashes(strtoupper(preg_replace('/ +/', ' ', trim($var)))); // Removing all trailing spaces and addslashes as needed
	}


	function clrSqlVar($var)
	{

		return addslashes(preg_replace('/ +/', ' ', trim($var))); // Removing all trailing spaces and addslashes as needed
	}

	function authenticate($login, $password = '')
	{

		/*
		 * retrieve the first created billing address if the default address id from preferences is not available
		*/
		$q = "SELECT
				c.contact_id, c.contact_num,c.magasin_code store_code, c.email email_address, c.nom last_name
				, c.prenom first_name
				, m.nom_magasin store_name, m.ville store_city, m.code_postal store_zip, m.stock_visible stock_active
				, m.adresse1 store_address, m.adresse2 store_address2, m.telephone1 store_phone, m.comments store_comments
				, cp.contact_password passwordU, c.civilite, cp.language_code, cp.confirm_key salt
				FROM contacts c
				INNER JOIN contact_preferences cp ON cp.contact_num = c.contact_num
				INNER JOIN magasins m ON m.magasin_code = c.magasin_code
				WHERE c.contact_num =:login
		";

		return ($this->fetchData($q, array(":login" => $login)));
	}
	
	// 	/*
	// 	 * retrieve the first created billing address if the default address id from preferences is not available
	// 	*/
	

	/*
     * function authentificate
     */

	function authenticateUser($email)
	{
		$q = "SELECT *
			FROM hr_employees 
			WHERE hr_employees.email = :email ";

		return ($this->fetchData($q, array(":email" => $email)));
	}

	function authenticateUserLogin($email)
	{
		$q = "SELECT *
			FROM hr_employees 
			WHERE hr_employees.email = :email";

		return ($this->fetchData($q, array(":email" => $email)));
	}

	function getUserData($id)
	{
		$q = "SELECT *
			FROM hr_employees hr
			WHERE hr.employee_id = :id";

		return ($this->fetchData($q, array(":id" => $id)));
	}

	/* update preferences for user */
	function updatePassword($id, $password)
	{
		$fields = array("password" => $password);
		$conditions = array("employee_id" => $id);
		if ($this->db->update("hr_employees", $fields, $conditions)) {
			return (true);
		} else {

			return (false);
		}
	}

	function debugError($e, $query = '')
	{
		//Display error
		if ($this->iniObj->debugSQL) {
			if (is_object($query)) {
				echo  "<br>DEBUG <br>Query  OBJECT: " . $query->queryString;
			} else {
				echo  "<br>DEBUG <br>Query : $query <br>";
			}
			if (is_object($e)) {
				echo "<br>Transaction failed - Error reported below :" .
					"<br />Error : " . $e->getMessage() . "<br />";
				"<br />N° : " . $e->getCode();
				"<br>Complete Error <pre>: ";
				// print_r($e);
				echo "</pre>";
			}
		}
	}

	function dataToHtmlForm($input)
	{
		if (is_array($input)) {
			$var = array();
			foreach ($input as $k => $v) {
				$var[$v->id] = $v->name;
			}
			return ($var);
		}
	}


	/* insertion exemple */
	function insertNewUserPassword($num, $pass, $prospect, $lang, $key, $roles)
	{
		try {
			$sql = $this->db->Connect();
			$q = 'INSERT contact_preferences (contact_num, contact_password,prospection,language_code,confirm_key,salt,email_confirme,last_update_date, roles ) ' .
				' VALUES ("' . $num . '","' . $pass . '","' . $prospect . '","' . $lang . '","' . $key . '","' . $key . '",0, now(), "' . $roles . '")';

			$sql->beginTransaction();
			$res = $sql->prepare($q);
			$sql->exec($q);
			//        $lastId=$sql->lastInsertId();
			$sql->commit();
			return (true);
		} catch (Exception $e) //en cas d'erreur
		{
			$sql->rollback();
			if ($this->iniObj->debugSQL) {
				$this->debugError($e);
			}
			return ($e);
		}
	}

	function sendDebugEmail($err, $function, $request = "")
	{
		$content = "Error from the function " . $function . "<br>\n " . print_r($err, true) . "\n <br>" . print_r($request, true);
		$this->lib->sendEmailAlert($this->iniObj->emailContact, $this->iniObj->DbEmail, "SQL Error", $content);
	}

	/* update  */
	
	function updateOrder($data)
	{
		$q = 'UPDATE orders SET order_status = "' . $data['status'] . '" WHERE order_id="' . $data['order_id'] . '"';

		if ($this->db->query($q)) return true;
		else return false;
	}

	function updateStatusRejectManager($status, $absence)
	{
		$fields = array("is_validate_by_manager" => $status, "is_validate" => 0);
		$conditions = array("absence_id" => $absence);
		if ($this->db->update("hr_absences", $fields, $conditions)) {

			return (true);
		} else {

			return (false);
		}
	}

	



}
