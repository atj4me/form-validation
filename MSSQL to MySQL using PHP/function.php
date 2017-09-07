<?php
function sql_query($query)
{
	$top = "/top [1-9]+/i";
	matchnreplace($top, &$query, "TOP");


	$query = str_ireplace("[dbo].","", $query);

	$brackets = array("[", "]");
	$query = str_ireplace($brackets, " ", $query);

	$query = str_ireplace("CHARINDEX", "LOCATE", $query);
	$query = str_ireplace("GO", ";<br>", $query);
	$query = str_ireplace("IDENTITY(1,1)", "", $query);
	unset($matches);
	$datediff = "/DATEDIFF\((.*?)\)/i";
	matchnreplace($datediff, &$query, "DATEDIFF");

	//change Convert
	$c_expr = "/CONVERT\((.*?)\)/i";
	matchnreplace($c_expr, &$query, "CONVERT");

	// //CHANGE YIME
	// $c_expr = "/DATEPART\((.*?)\)/i";
	// matchnreplace($c_expr, &$query, "DATEPART");


	$query = str_ireplace('datepart(yyyy,', 'year(', $query);
	$query = str_ireplace('datepart(yy,', 'year(', $query);
	$query = str_ireplace('datepart(mm,', 'month(', $query);
	$query = str_ireplace('datepart(dd,', 'date(', $query);


	return $query;


}
function sql_get_last_message()
{
	return mysql_error();
}
function sql_error()
{
	return mysql_error();
}
function sql_fetch_array($query)
{
	return mysql_fetch_array($query);
}
function sql_num_rows($query)
{
	return mysql_num_rows($query);
}
function matchnreplace($datediff, &$query, $type){
	preg_match_all($datediff, $query, $matches);
	switch($type){
		case 'TOP'  :	 	$query = preg_replace($datediff, "", $query);
	    					$query .= str_ireplace("TOP", "LIMIT", $matches[0][0]);
							break;
		case 'DATEDIFF' :	foreach (array_unique($matches[1]) as $old_match) {
								$match = explode(",",$old_match);
								$match = array($match[0], $match[2], $match[1]);
								$match = implode(",", $match);
								$query = str_ireplace($old_match, $match, $query);
								$query = str_ireplace($type, "TIMESTAMPDIFF", $query);
							}
							break;

		case 'CONVERT'  :	foreach (array_unique($matches[1]) as $old_match) {
								$match = explode(",",$old_match);
								$match = $match[1] ." AS ". $match[0];
								$query = str_ireplace($old_match, $match, $query);
								$query = str_ireplace($type, "CAST", $query);
							}
							break;


	}

}
