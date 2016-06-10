<?php

namespace leyo\Mpesa;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MpesaController extends Controller
{

    public function getSecurityCredential($source){

        $crypttext;
        $padding = "OPENSSL_PKCS1_PADDING";
        $fp=fopen("/var/www/wallet/app/Http/Controllers/ApiCryptPublicOnly.cer","r");
        $pub_key=fread($fp,8192);
        fclose($fp);
        $pub_key_string=openssl_get_publickey($pub_key);
        openssl_public_encrypt($source,$crypttext,$pub_key_string);
        /*this simply passes the string contents of pub_key_string back to be decoded*/
        $test = base64_encode($crypttext);
        return $test;
    }

    public function sendmoney($phone,$amount){
        date_default_timezone_set('Africa/Nairobi');
        $no = "254".substr($phone,-9);

        $timestamp_ = date("YdmHis");
            $real_pass = base64_encode(hash('sha256', SPID . "" . PASSWORD . "" . $timestamp_));
            $securityCredential = self::getSecurityCredential(initiator_pass);
            $rand = rand(123456, 654321);
            $originId = spId . "_".initiator_username."_" . $rand;
            $type = 2;
            $third_party_id = null;
            $reqTime = date('Y-m-d') . "T" . date('H:i:s') . ".0000521Z"; //2014-10-21T09:47:19.0000521Z

            $curlData = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                        <s:Header>
<h:RequestSOAPHeader xmlns:h="http://www.huawei.com.cn/schema/common/v2_1" xmlns="http://www.huawei.com.cn/schema/common/v2_1" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<h:spId>'.SPID.'</h:spId>
<h:spPassword>'.$real_pass.'</h:spPassword>
<h:serviceId>'.SERVICEID.'</h:serviceId>
<h:timeStamp>'.$timestamp_.'</h:timeStamp>
</h:RequestSOAPHeader>
</s:Header>
                        <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<RequestMsg xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<![CDATA[<request xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<Transaction>
<CommandID>BusinessPayment</CommandID>
<OriginatorConversationID>'.$originId.'</OriginatorConversationID>
<Parameters><Parameter><Key>Amount</Key><Value>'.$amount.'</Value></Parameter></Parameters>
<ReferenceData><ReferenceItem><Key>QueueTimeoutURL</Key><Value>'.result_url.'</Value></ReferenceItem></ReferenceData>
<Timestamp>'.$reqTime.'</Timestamp></Transaction>
<Identity>
<Caller>
<CallerType>'.$type.'</CallerType>
<ThirdPartyID>'.SPID.'</ThirdPartyID>
<Password>'.PASSWORD.'</Password>
<CheckSum></CheckSum>
<ResultURL>'.result_url.'</ResultURL>
</Caller>
	<Initiator>
			<IdentifierType>11</IdentifierType>
			<Identifier>'.initiator_username.'</Identifier>
			<SecurityCredential>'.$securityCredential.'</SecurityCredential>
			<ShortCode>'.B2CPaybill.'</ShortCode>
		</Initiator>
<PrimaryParty>
<IdentifierType>4</IdentifierType>
<Identifier>'.B2CPaybill.'</Identifier>
</PrimaryParty>
<ReceiverParty>
<IdentifierType>1</IdentifierType>
<Identifier>'.$no.'</Identifier>
</ReceiverParty>
</Identity>

<KeyOwner>1</KeyOwner></request>]]></RequestMsg>
</s:Body>
                        </s:Envelope>';

            return self::sendRequest($curlData);
    }


    public function sendRequest($curlData){

        $url = 'https://196.201.214.137:18423/mminterface/request';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 360);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 360);
        curl_setopt($curl, CURLOPT_ENCODING, 'utf-8');

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'SOAPAction:""',
            'Content-Type: text/xml; charset=utf-8',
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
//CURLOPT_VERBOSE        => true,
//curl_setopt($curl, CURLOPT_SSLCERT, '/var/www/html/sdp_apps/services/b2c/pkcs/testbroker.crt');
        curl_setopt($curl, CURLOPT_SSLCERT, SSL_CERT_PATH);
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');

//curl_setopt($curl, CURLOPT_SSLKEY, '/var/www/html/sdp_apps/services/b2c/pkcs/certs_chain.pem');
        curl_setopt($curl, CURLOPT_SSLKEY, SSL_KEY_PATH);
        curl_setopt($curl, CURLOPT_SSLKEYPASSWD, SSL_PASS);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlData);
        //curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'read_header'); // get header

        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Curl Error: ' . curl_error($curl) . "\n\n";
        }

        echo date('Y-m-d H:i:s') . ": Response: $result\n";
        curl_close($curl);

        return $result;

//$xml = new SimpleXMLElement($result);
//print_r($xml);

        function read_header($curl, $string) {
            print "Received header: $string\n\n";
            return strlen($string);
        }
    }

}
