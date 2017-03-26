<h1>TOP LEADERBOARD PROGRESS</h1>
<table border="1"><tr><th>#</th><th>UserID</th><th>UserName</th><th>Stars</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$starsgain = array();
$time = time() - 86400;
$query = $db->prepare("SELECT * FROM actions WHERE type = '9' AND timestamp > :time");
$query->execute([':time' => $time]);
$result = $query->fetchAll();
foreach($result as &$gain){
	$starsgain["a".$gain["account"]] += $gain["value"];
	
}
arsort($starsgain);
foreach ($starsgain as $userIDa => $stars){
	$userID = substr($userIDa, 1);
	$query = $db->prepare("SELECT userName, isBanned FROM users WHERE userID = :userID");
	$query->execute([':userID' => $userID]);
	$userinfo = $query->fetchAll()[0];
	$username = htmlspecialchars($userinfo["userName"], ENT_QUOTES);
	if($userinfo["isBanned"] == 0){
		$x++;
		echo "<tr><td>$x</td><td>$userID</td><td>$username</td><td>$stars</td></tr>";
	}
}  
?>
</table>