<!--</?php
define('HOST_NAME',"localhost"); 
define('PORT',"8090");
$null = NULL;

require_once("class.chathandler.php");
$chatHandler = new ChatHandler();

$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socketResource, 0, PORT);
socket_listen($socketResource);

$clientSocketArray = array($socketResource);
while (true) {
	$newSocketArray = $clientSocketArray;
	socket_select($newSocketArray, $null, $null, 0, 10);
	
	if (in_array($socketResource, $newSocketArray)) {
		$newSocket = socket_accept($socketResource);
		$clientSocketArray[] = $newSocket;
		
		$header = socket_read($newSocket, 1024);
		$chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);
		
		socket_getpeername($newSocket, $client_ip_address);
		$connectionACK = $chatHandler->newConnectionACK($client_ip_address);
		
		$chatHandler->send($connectionACK);
		
		$newSocketIndex = array_search($socketResource, $newSocketArray);
		unset($newSocketArray[$newSocketIndex]);
	}
	
	foreach ($newSocketArray as $newSocketArrayResource) {	
		while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
			$socketMessage = $chatHandler->unseal($socketData);
			$messageObj = json_decode($socketMessage);
			
			$chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
			$chatHandler->send($chat_box_message);
			break 2;
		}
		
		$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
		if ($socketData === false) { 
			socket_getpeername($newSocketArrayResource, $client_ip_address);
			$connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address);
			$chatHandler->send($connectionACK);
			$newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
			unset($clientSocketArray[$newSocketIndex]);			
		}
	}
}
socket_close($socketResource);
?>-->







<html>
<head>
<style type="text/css">
.chat {
background-color: transparent;
border: 1px solid;
height:300px;
width:300px;
overflow:auto;
}
</style>
<script type="text/Javascript">
	function scroll()
	{
		var div=document.getElementById('chat');
		div.scrollTop=100000000;
	}
</script>
<meta http-equiv="refresh" content="15; url=<?php echo $_SERVER['PHP_SELF']; ?>">
</head>
<body OnLoad="scroll();">
<center>
<p><font size="10px;">Chat</font></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div id="chat" class="chat">
<?php
$name=$_POST['name'];
$message=$_POST['text'];
if ($name AND $message)
{
mysql_query("INSERT INTO Chat VALUES ('$name', '$message');");
}
echo "Benvenuto nella Chat";
$query_select=mysql_query("SELECT * FROM Chat");
while($rows=mysql_fetch_array($query_select))
{
    echo "<p align='left'>{$rows['names']}:</p><p></p>";
$messages=htmlspecialchars($rows['messages']);

$messages=str_replace(":)", " <img src=''></img>", $messages);
/*$messages=str_replace(":(", " <img src='./Chat/:(.png'></img>", $messages);
$messages=str_replace("=)", " <img src='./Chat/=).png'></img>", $messages);
$messages=str_replace("=(", " <img src='./Chat/=(.png'></img>", $messages);
$messages=str_replace(":|", " <img src='./Chat/:|.png'></img>", $messages);
$messages=str_replace(":P", " <img src='./Chat/:P.png'></img>", $messages);
$messages=str_replace(":D", " <img src='./Chat/:D.png'></img>", $messages);
$messages=str_replace("D:", " <img src='./Chat/D:.png'></img>", $messages);
$messages=str_replace("XD", " <img src='./Chat/XD.png'></img>", $messages);
$messages=str_replace("xD", " <img src='./Chat/xD.png'></img>", $messages);
$messages=str_replace(":/", " <img src='./Chat/:||.png'></img>", $messages);
*/
echo "<p align='left'>$messages</p>";
}
?>
</div>
<table>
<tr>
<td>Nome:</td>
<td><input type="text" name="name" value="<?php echo $name; ?>"></td>
</tr>
<tr>
<td>Testo:</td>
<td><textarea name="text"></textarea></td>
</tr>
<table>
<tr>
<td><input type="submit" value="Invia"></td>
<td><input type="reset" value="Resetta"></td>
</tr>
</table>
</form>
</center>
</body>
</html>
<?php
//Configurazioni
$mysql_host="";
$mysql_username="";
$mysql_password="";
$mysql_database="";
$connect=mysql_connect($mysql_host, $mysql_username, $mysql_password);
$db=mysql_select_db($mysql_database, $connect);
if(!$connect){echo "Impossibile connettersi al server!";}
if(!$db){echo "Impossibile connettersi al database!";}
mysql_query("DROP TABLE Chat") or die(mysql_error());
mysql_query("CREATE TABLE Chat(names VARCHAR(30) NOT NULL, messages VARCHAR(1000) NOT NULL)") or die(mysql_error());
$self=$_SERVER['PHP_SELF'];
$self=str_replace("PulisciChat.php", "Chat.php", $self);
header("location:$self");
?>
