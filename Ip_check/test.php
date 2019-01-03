<html>
<head>
<title>DNSBL Lookup Tool - IP Blacklist Check Script</title>
</head>
<body>
<form action="" method="get">
<input type="text" value="" name="ip" />
<input type="submit" value="LOOKUP" />
</form>
<?php
/***************************************************************************************
This is a simple PHP script to lookup for blacklisted IP against multiple DNSBLs at once.
 
You are free to use the script, modify it, and/or redistribute the files as you wish.
 
Homepage: http://dnsbllookup.com
****************************************************************************************/
function dnsbllookup($ip){
$dnsbl_lookup=array(
    "bl.suomispam.net",
    "dnsbl-1.uceprotect.net",
    "dnsbl-2.uceprotect.net",
    "dnsbl-3.uceprotect.net",
    "dnsbl.dronebl.org",
    "dnsbl.sorbs.net",
    "zen.spamhaus.org"); // Add your preferred list of DNSBL's
    $listed = '';
if($ip){
$reverse_ip=implode(".",array_reverse(explode(".",$ip)));
foreach($dnsbl_lookup as $host){
    
if(checkdnsrr($reverse_ip.".".$host.".","A")){
$listed.=$reverse_ip.'.'.$host.' <font color="red">Listed</font><br />';
}
}
}
if($listed){
echo $listed;
}else{
echo '"A" record was not found';
}
}
$ip=$_GET['ip'];
if(isset($_GET['ip']) && $_GET['ip']!=null){
//if(filter_var($ip,FILTER_VALIDATE_IP)){
echo dnsbllookup($ip);
//}else{
//echo "Please enter a valid IP";
echo gethostbyname($ip);

//}
}
?> 
</body>
</html>