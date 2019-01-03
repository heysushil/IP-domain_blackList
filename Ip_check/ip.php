<?php
$dnsbl_lookup = array(
            // "sbl-xbl.spamhaus.org",
            // "dnsbl.ahbl.org",
            // "bl.csma.biz", //added //   
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
            //"dnsbl.njabl.org",
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
        // $table_tr = '';
        // $user_data_arr = $this->Mailget_Panel_model->get_pmta_and_tracking_ip_domain_detail();
        // if (!empty($user_data_arr)) {
        //     $timeout = 10;
        //     foreach ($user_data_arr as $user_data_arr_row) {
        //         $listed = "";
        //         $ip = $user_data_arr_row->domain_ip;
        //         $reasons = (array) json_decode($user_data_arr_row->blacklist_name);
        //         $id = $user_data_arr_row->id;

//---------------------------------------------------------------------//

 $ip = (isset($_POST['ipCheck'])) ? $_POST['ipCheck'] : FALSE;

 

 ini_set('max_execution_time', 300);

//---------------------------------------------------------------------//
                if ($ip) {
                    $get_hostname = array();
                    $ip_status = 'no';
                    $listed = "";
                   
                    foreach ($dnsbl_lookup as $hostname) {
                       
                        if(!ip2long($ip)){
                            $ip = gethostbyname($ip);
                        
                        }
                        $host = implode(".", array_reverse(explode('.', $ip))) . '.' . $hostname . '.';
                        //$response = shell_exec('nslookup -type=A ' . escapeshellcmd($host));

                        if (checkdnsrr($host, "A")) {
                            $listed .= $host . ' <font color="red">Listed IP = '.$ip.'</font><br /> ';
                        }
                    }

                    if (empty($listed)) {
                        echo 'Site is OK IP = '.$ip;
                    } else {
                        echo $listed;
                    }
                         

                    
						/*
                        if (strpos(trim($response), 'Name:') != 0) {
                            $ip_status = 'yes';
                            //$get_hostname = $hostname;
                            //break;
                            $txtrecords = dns_get_record("$host", DNS_TXT);
                            foreach ($txtrecords as $txtrecord) {
                                if(!isset($reasons[$hostname])){
                                    $reasons[$hostname] = array(
                                        'domain' => $hostname,
                                        'reason' => $txtrecord['txt']
                                    );
                                    // IP added into new blacklist server.
                                    $message = '<pre><b>Tracking Ip Blacklisted</b> - <br/><br/>'
                                        . 'Blacklist IP/Domain Name - ' . $user_data_arr_row->domain_ip . '<br/>'
                                        . 'Blacklist Server Name - ' . $hostname . '<br/>'
                                        . 'Reason - '. $txtrecord['txt'] . '<br/>'
                                        . 'Date - ' .date('Y-m-d H:i:s', strtotime('' . date('Y-m-d H:i:s') . ' +5 hours 30 minutes')). '<br/></pre>';
                                    $this->Builder_model->MailgetMail('enquiry@formget.com','['. $user_data_arr_row->domain_ip . '] - Tracking Ip Blacklisted',$message, 'MailGet');
                                }
                            }
							
                        } else {
                            if(isset($reasons[$hostname])){
                                // IP removed from $hostname blacklist server.
                                $message = '<pre><b>Tracking Ip Delisted</b> - <br/><br/>'
                                    . 'Blacklist IP/Domain Name - ' . $user_data_arr_row->domain_ip . '<br/>'
                                    . 'Blacklist Server Name - ' . $hostname . '<br/>'
                                    . 'Reason - '. $reasons[$hostname]->reason . '<br/>'
                                    . 'Date - ' .date('Y-m-d H:i:s', strtotime('' . date('Y-m-d H:i:s') . ' +5 hours 30 minutes')). '<br/></pre>';
                                unset($reasons[$hostname]);
                                $this->Builder_model->MailgetMail('enquiry@formget.com','['. $user_data_arr_row->domain_ip . '] - Tracking Ip Delisted',$message, 'MailGet');
                            }
                        }
						*/
                    //foreach}
					/*
                    $get_hostname = $reasons;
                    if($user_data_arr_row->black_listed == 'no' && $ip_status == 'yes'){
                        $update_arr = array(
                            'sender_score' => '',
                            'black_listed' => 'yes',
                            'blacklist_name' => json_encode($get_hostname),
                            'date' => date('Y-m-d H:i:s')
                        );
                        $this->Mailget_Panel_model->update_pmta_and_tracking_ip_domain_detail($id, $update_arr);
                        //$this->Builder_model->MailgetMail('enquiry@formget.com','['. $ip . '] - Tracking Ip Blacklisted','<pre>Tracking Ip Blacklisted - ' .date('Y-m-d H:i:s'). '<br>'. print_r($update_arr, true) . '</pre>', 'MailGet');
                    } elseif($user_data_arr_row->black_listed == 'yes' && $ip_status == 'no'){
                        $update_arr = array(
                            'sender_score' => '',
                            'black_listed' => 'no',
                            'blacklist_name' => '',
                            'date' => date('Y-m-d H:i:s')
                        );
                        $this->Mailget_Panel_model->update_pmta_and_tracking_ip_domain_detail($id, $update_arr);
                        //$this->Builder_model->MailgetMail('enquiry@formget.com','['. $ip . '] - Tracking Ip Delisted','<pre>Tracking Ip Delisted - ' .date('Y-m-d H:i:s'). '<br>'. print_r($update_arr, true) . '</pre>', 'MailGet');
                    } else {
                        $update_arr = array(
                            'blacklist_name' => json_encode($get_hostname)
                        );
                        $this->Mailget_Panel_model->update_pmta_and_tracking_ip_domain_detail($id, $update_arr);
                    }
					
                }
            }*/
        }

        ?>

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




