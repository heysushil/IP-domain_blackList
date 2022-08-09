<!DOCTYPE html>
        <html lang="en">
        <head>
        </head>
        <body>
            <form action="" method='post'>Enter IP:
                 <input type="text" name='ipCheck'>
                 <input type="submit">
            </form>

        </body>
        </html>


<?php
// For execution time
$start = microtime(true);

$dnsbl_lookup = array(
    //"dbl.spamhaus.org",
    "list.dsbl.org",
    "multi.surbl.org",
    "tor.ahbl.org",
    "dnsbl.ahbl.org",
    "bl.csma.biz",
    "0spam.fusionzero.com",
    "dnsbl.spfbl.net",
    "rbl.realtimeblacklist.com",
    "rbl.megarbl.net",
    "all.s5h.net",
    "srnblack.surgate.net",
    "bl.blocklist.de",
    "dnsbl.inps.de",
    "ix.dnsbl.manitu.net",
    "hostkarma.junkemailfilter.com",
    "auth.spamrats.com",
    "spam.spamrats.com",
    "dyna.spamrats.com",
    "noptr.spamrats.com",
    "bad.psky.me",
    "db.wpbl.info",
    "dnsrbl.org",
    "dnsbl.cobion.com",
    "sbl-xbl.spamhaus.org",
    "nomail.rhsbl.sorbs.net",
    "badconf.rhsbl.sorbs.net",
    "rhsbl.sorbs.net",
    "noservers.dnsbl.sorbs.net",
    "spam.dnsbl.sorbs.net",
    "old.spam.dnsbl.sorbs.net",
    "recent.spam.dnsbl.sorbs.net",
    "new.spam.dnsbl.sorbs.net",
    "safe.dnsbl.sorbs.net",
    "dnsbl.proxybl.org",
    "crawler.rbl.webiron.net",
    "all.rbl.webiron.net",
    "stabl.rbl.webiron.net",
    "cabl.rbl.webiron.net",
    "babl.rbl.webiron.net",//added
    "bl.suomispam.net",
    "dbl.suomispam.net",
    "access.redhawk.org",
    "b.barracudacentral.org",
    "bl.emailbasura.org",   
    "bl.spamcannibal.org",
    "bl.spamcop.net",
    "bl.technovision.dk",
    "blackholes.five-ten-sg.com",
    "blackholes.wirehub.net",
    "blacklist.sci.kun.nl",
    "block.dnsbl.sorbs.net",
    "blocked.hilli.dk",
    "bogons.cymru.com",
    "cart00ney.surriel.com",
    "cbl.abuseat.org",
    "dev.null.dk",
    "dialup.blacklist.jippg.org",
    "dialups.mail-abuse.org",
    "dialups.visi.com",
    "dnsbl.antispam.or.id",
    "dnsbl.cyberlogic.net",
    "dnsbl.kempt.net",
    "dnsbl.njabl.org",
    "dnsbl.sorbs.net",
    "dnsbl-1.uceprotect.net",
    "dnsbl-2.uceprotect.net",
    "dnsbl-3.uceprotect.net",
    "duinv.aupads.org",
    "dul.dnsbl.sorbs.net",
    "dul.ru",
    "escalations.dnsbl.sorbs.net",
    "hil.habeas.com",
    "http.dnsbl.sorbs.net",
    "intruders.docs.uu.se",
    "ips.backscatterer.org",
    "korea.services.net",
    "mail-abuse.blacklist.jippg.org",
    "misc.dnsbl.sorbs.net",
    "msgid.bl.gweep.ca",
    "new.dnsbl.sorbs.net",
    "no-more-funn.moensted.dk",
    "old.dnsbl.sorbs.net",
    "pbl.spamhaus.org",
    "proxy.bl.gweep.ca",
    "psbl.surriel.com",
    "pss.spambusters.org.ar",
    "rbl.schulte.org",
    "rbl.snark.net",
    "recent.dnsbl.sorbs.net",
    "relays.bl.gweep.ca",
    "relays.bl.kundenserver.de",
    "relays.mail-abuse.org",
    "relays.nether.net",
    "rsbl.aupads.org",
    "sbl.spamhaus.org",
    "smtp.dnsbl.sorbs.net",
    "socks.dnsbl.sorbs.net",
    "spam.dnsbl.sorbs.net",
    "spam.olsentech.net",
    "spamguard.leadmon.net",
    "spamsources.fabel.dk",
    "web.dnsbl.sorbs.net",
    "whois.rfc-ignorant.org",
    "xbl.spamhaus.org",
    "zen.spamhaus.org",
    "zombie.dnsbl.sorbs.net",
    "bl.tiopan.com",
    "dnsbl.abuse.ch",
    "tor.dnsbl.sectoor.de",
    "ubl.unsubscore.com",
    "cblless.anti-spam.org.cn",
    "dnsbl.tornevall.org",
    "dnsbl.anticaptcha.net",
    "dnsbl.dronebl.org",
    "truncate.gbudb.net"
);


$ip = (isset($_POST['ipCheck'])) ? $_POST['ipCheck'] : FALSE;

ini_set('max_execution_time', 0);


if (filter_var($ip, FILTER_VALIDATE_IP) == true) 
{

    $listed = "";
                    // echo 'hello', ip2long($ip);die;
                    // var_dump(filter_var($ip, FILTER_VALIDATE_IP));die;
                    foreach ($dnsbl_lookup as $hostname) {
                       
                        if(!ip2long($ip)){
                            $ip = gethostbyname($ip);
                            // echo 'Check ip:  ', $ip;
                        
                        }
                        $host = implode(".", array_reverse(explode('.', $ip))) . '.' . $hostname . '.';
                        // echo 'Host: ', $host , '<br>';
                        // $record = dns_get_record($host,DNS_TXT);
    
                        if (checkdnsrr($host, "A")) {
                            $listed .= $host . ' <font color="red">Listed IP = '.$ip.'</font><br /> ';
                        }else{
                            $listed .= $host . ' <font color="green">Not Listed IP = '.$ip.'</font><br /> ';
                        }
                    }

                    if (empty($listed)) {
                        echo 'Site is OK IP = '.$ip;
                    } else {
                        echo $listed;
                    }
}else{
    echo("$ip is not valid.<br><br>");
}

$time_end = microtime(true);
echo 'Script running time is: ', $execution_time = ($time_end - $start)/60;
?>