<?php // Simple PHP script to lookup for blacklisted IP against multiple DNSBLs at once. ?>
<html>
<head>
    <title>DNSBL Lookup Tool - IP Blacklist Check Script</title>
</head>
<body>
<h2>IP Blacklist Check Script</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input type="text" value="" name="ip"/>
    <input type="submit" value="LOOKUP"/>
</form>
<?php

/**
 * The IP-address to be looked up.
 * @param string $ip
 */
function dnsbllookup($ip)
{
    // Add your preferred list of DNSBL's
    $dnsbl_lookup = [
        "dnsbl-1.uceprotect.net",
        "dnsbl-2.uceprotect.net",
        "dnsbl-3.uceprotect.net",
        "dnsbl.dronebl.org",
        "dnsbl.sorbs.net",
        "zen.spamhaus.org",
        "bl.spamcop.net",
        "list.dsbl.org"
    ];

    $listed = "";

    if ($ip) {
        $reverse_ip = implode(".", array_reverse(explode(".", $ip)));
        foreach ($dnsbl_lookup as $host) {
            if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {
                $listed .= $reverse_ip . '.' . $host . ' <font color="red">Listed</font><br />';
            }
        }
    }

    if (empty($listed)) {
        echo '"A" record was not found';
    } else {
        echo $listed;
    }
}

if (isset($_POST['ip']) && $_POST['ip'] != null) {
    $ip = $_POST['ip'];
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        echo dnsbllookup($ip);
    } else {
        echo "Please enter a valid IP";
    }
}

?>
</body>
</html>