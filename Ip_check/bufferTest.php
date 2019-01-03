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

$ip=$_POST['ipCheck'];
$tstart=time();
echo $ip."<BR>";

function flush_buffers()
{ 
    ini_set('output_buffering','on');
    //ini_set('zlib.output_compression', 0);
    ini_set('implicit_flush',1);
    ini_set('max_execution_time', 0);
    ob_implicit_flush();

    //echo ("<html><head><head><body>");
    for($i=0;$i<20;$i++) {
       // echo $i;
        echo str_repeat(" ", 500);
        ob_flush();
        flush();
       // sleep(1);
    }
}

function dnsbllookup($ip)
{
    $dnsbl_lookup=array(
    "access.redhawk.org",
    "b.barracudacentral.org",
    "bl.csma.biz",
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
    "dnsbl.ahbl.org",
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
"zen.spamhaus.org",
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
    "tor.ahbl.org",
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
    "dnsbl.dronebl.org"
    ); // Add your preferred list of DNSBL's
    $AllCount = count($dnsbl_lookup);
    $BadCount = 0;
    if($ip)
    {
        $reverse_ip = implode(".", array_reverse(explode(".", $ip)));
        foreach($dnsbl_lookup as $host)
        {
            if(checkdnsrr($reverse_ip.".".$host.".", "A"))
            {
               echo "<span color='#339933'>Listed on ".$reverse_ip.'.'.$host."!</span><br/>";
                flush_buffers();
                $BadCount++;
            }
            else
            {
//                echo "Not listed on ".$reverse_ip.'.'.$host."!<br/>";
                flush_buffers();
            }
        }
    }
    else
    {
//        echo "Empty ip!<br/>";
        flush_buffers();
    }

  echo "This ip has ".$BadCount." bad listings of ".$AllCount."!<br/>";

    flush_buffers();

    if($BadCount==0)
    {
   //     include("index.php");
 echo "Not blacklisted ";
    }
    else
    {
    //    include("default.htm");
 echo "Blacklisted";
    }

}

if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/",@$ip) == true)
{
    dnsbllookup($ip);
}
$tend=time();

$tvar=$tend-$tstart;
echo "<BR> took $tvar seconds <br>";
?>