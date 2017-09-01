<?php
$status = isset($_GET['status']) ? $_GET['status'] : '' ;
$request_url = $_SERVER['REQUEST_URI'];
$host = $_SERVER['HTTP_HOST'];

//function for displaying array
function prep($arr){
	?>
	<pre>
		<?php print_r($arr);
		?>
	</pre>
	<?php
}

//function for removing the last path of an url
function remove_last($url){
	$arr_url = explode('/', $url);
	$arr_url = array_filter($arr_url);
	 if(!file_exists($url))
		$poped = array_pop($arr_url);
	else
		return false;
	 $url = implode("/", $arr_url);
	 if($url != '' OR $poped != '')
	 	return array("new_url" => $url, 'popval' => $poped);
	 else
		return false;
}
$new_url = $request_url;
while($rslt = remove_last($new_url)){
$new_url = $rslt['new_url'];
$poped[] = $rslt['popval'];
$rslt = remove_last($new_url);
}
$host = trim($host,"/");
$dir = scandir("../".$new_url);
	for($i=sizeof($poped)-1; $i>=0; --$i){
		$temp_path = array();
		if(!file_exists("../".$new_url.$poped[$i])){
			foreach($dir as $path) {
			similar_text($path, $poped[$i], $percent);
			if($percent>0){
				if($path)
				$path = trim($path, "/");
				$arr_path = str_replace("//", "/", $host."/".$new_url."/".$path);
			 	$redir[] = array("path" => "http://".$arr_path,
							"perc" => $percent );
				 $temp_path[] = array("new_url" => $new_url."/".$path,
							"perc" => $percent );

			}
			}
	usort($temp_path, 'sortByOrder');
	$new_url = $temp_path[0]['new_url'];
	$new_url = trim($new_url,"/");
		}
		else{

			$new_url .= $poped[$i];
			$new_url = trim($new_url,"/");
		}

	$dir = scandir("../".$new_url);
}
if(isset($redir))
usort($redir, 'sortByOrder');
function sortByOrder($a, $b)
{
    $diff = $a['perc'] - $b['perc'];
    if($diff == 0)
    	return 0;
    return ($diff < 0) ? +1 : -1 ;
}
$new_url = ltrim($new_url,"/");
$new_url = "http://".$host."/".$new_url;
switch($status){
	case '400' : 	$title = "400 BAD REQUEST";
					$head = "Bad Request";
					$content = "There was an error in your request.";
					break;

	case '401'  : 	$head = "Authorization Required";
					$title = "401 NOT AUTHORIZED";
					$content = "This server could not verify that you are authorized to access the document requested. Either you supplied the wrong credentials (e.g., bad password), or your browser doesn't understand how to supply the credentials required.";
					break;

	case '403'  :	$head = "Permission Denied";
					$title = "403 Restricted Access";
					$content = "You have no permission to access this page. <br />403 Error";
					break;

	case '404' 	:  	$head = "Page Not Found in this server";
					$title = "404 Page Not Found";
					$content = "We can't find the page you are looking for....";
					break;

	case '500' 	: 	$head = "Internal Server Error";
					$title = "500 Internal Server Error";
					$content = "The server encountered an internal error or misconfiguration and was unable to complete your request";
					break;

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE><?=$title?></TITLE>
<style>
body{
	background-color: #000;
}
.h1text {
    font-size:92px;
    font-weight:bold;
    font-family:Arial, Helvetica, sans-serif;
    color:yellow;
}
.redtext {
	font-size:62px;
	font-weight:bold;
	font-family:Arial, Helvetica, sans-serif;
	color:#ee1d23;
}

.whitetext {
	font-size:32px;
	font-weight:bold;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
}
.linktext {
	font-size:22px;
	font-weight:bold;
	font-family:Arial, Helvetica, sans-serif;
	color: orange;
}
.linktext p{

	padding: 5px;
	margin-left:50px;
}
.linktext li{
	list-style-type: "-  ";
	margin-left: 150px;
}
.link {
	font-size:15px;
	text-decoration: none;
	color: yellow;
	font-weight:normal;
}
.link:hover {
	text-decoration: none;
	color: #ee1d23;
}
input[type="text"] {
    width: 24%;
    color: white;
    background-color: #000;
    border: 0;
        border-bottom-width: 0px;
        border-bottom-style: none;
        border-bottom-color: currentcolor;
    padding: 1em 2em;
}
input[type="text"]:hover {
    width: 24%;
    color: #ee1d23;
    background-color: #000;
    border: 0;
        border-bottom-width: 0px;
        border-bottom-style: none;
        border-bottom-color: currentcolor;

    border-bottom: 1px #ee1d23 solid;
    padding: 1em 2em;
}
input[type="submit"] {
    margin: 0 12em;
    width: 6%;
    color: #FFF;
    background-color: #000;
    border: 1px solid;
    padding: 1em 2em;
}
input[type="submit"]:hover {
    margin: 0 12em;
    width: 6%;
    color: #FFF;
    background-color: #ee1d23;
    border: 1px #ee1d23 solid;
    padding: 1em 2em;
}
.bar{
	margin-left: 15%;
	width:80%;
	position: absolute;
	bottom: 0;
	color: #FFF;
}
#wrap{
	overflow:hidden;
}
.pad100{
	margin : 50px 0px;
}
.container{
	max-width: 1300px;
width: 100%;
}
.fleft{
	float:left;
	width: 20%;
	overflow: hidden;
}
.fright{
	float:right;
	width: 20%;
	overflow: hidden;
}
.urltext{
	background-color: #000;
padding: 4px;
}
</style>
</head>
<body>
<div class="container">
<div align="center" class="h1text pad100" id="1" ><?=$title?></div>
<div align="center" class="redtext pad100" id="2"><?=$head?></div>
 <div align="center" class="whitetext pad100" id="3"><?=$content?></div>
 <div align="left" class="linktext" ><p>Did you mean.. ?</p>
 	<script>
	var c = 0;
	document.getElementById('2').innerHTML = "Redirecting this page in <br><span id='4' class='h1text'>0</span> Seconds";
	document.getElementById('3').innerHTML = "<div id='wrap'><span id='5' class='whitetext'>#</span><br><span id='8' class='whitetext fleft'></span><span class='linktext urltext'>URL : <?=$new_url?></span><span id='9' class='whitetext fright'></span><br><span id='6' class='whitetext'>#</span></div>";
	document.getElementById('1').style.display = "none";

	setInterval(function(){
		document.getElementById('4').innerHTML =  ++c ;
	}, 1000);
	var myVar = setInterval(function(){
		document.getElementById('5').innerHTML +=  "#" ;
		document.getElementById('6').innerHTML +=  "#" ;
		document.getElementById('8').innerHTML +=  "#" ;
		document.getElementById('9').innerHTML +=  "#" ;
	}, 100);
	setTimeout(function(){
		clearInterval(myVar);
		window.location = "<?=$new_url?>";
		}, 10000);
	</script>
    <ul>
  <?php


$count = 0;
foreach($redir as $val){
  	if($val['perc']>80 && ++$count == 1) { ?>



<?php } ?>

    <?php
  	if($val['perc']>50) { ?>

    	<li><a href="<?=$val['path']?>" class="link" ><?=$val['path']?></a></li>

   <?php } } ?>
   </ul>
  </div>
</div>

</body>
</html>
