<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//
//        $data = array(
//            'phone' => '+254710817054',
//            'name' => 'WILSON KANYI MAINA',
//            'transaction_code' => 'KG816PWY31',
//            'paybill' => '949494',
//            'account' => 'C2004 sponsorship',
//            'amount' => '14000',
//            'transaction_time' => '20160714222052',
//        );
//
//        print_r(json_encode($data));
//        exit;
        //
        date_default_timezone_set('Africa/Nairobi');
//        $SERVICEID = "107025000";
//        $spId = '107025';
//        $password = 'Kenya123!';
        $spId = '100400';
        $SERVICEID = "100400000";
        $password = 'Africa*765';
//        $spId = '100399';
//        $SERVICEID = "100399000";
//        $password = 'Inuka$321';
        $timestamp_ = date("YdmHis");
        $real_pass = base64_encode(hash('sha256', $spId . "" . $password . "" . $timestamp_));
        //$initiator_pass = 'Aa12345%';
        //$securityCredential = self::getSecurityCredential($initiator_pass);
//
//        print_r($securityCredential);
//        exit;
        $rand = rand(123456, 654321);
        $originId = $spId . "_mobibeta_" . $rand;
		$type = 2;
		$third_party_id = null;
        $reqTime = date('Y-m-d') . "T" . date('H:i:s') . ".0000521Z"; //2014-10-21T09:47:19.0000521Z

        $curlData = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Header>
<h:RequestSOAPHeader xmlns:h="http://www.huawei.com.cn/schema/common/v2_1" xmlns="http://www.huawei.com.cn/schema/common/v2_1" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<h:spId>'.$spId.'</h:spId>
<h:spPassword>'.$real_pass.'</h:spPassword>
<h:serviceId>'.$SERVICEID.'</h:serviceId>
<h:timeStamp>'.$timestamp_.'</h:timeStamp>
</h:RequestSOAPHeader>
</s:Header>
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<RequestMsg xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<![CDATA[<request xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<Transaction>
<CommandID>BusinessPayment</CommandID>
<OriginatorConversationID>'.$originId.'</OriginatorConversationID>
<Parameters><Parameter><Key>Amount</Key><Value>100</Value></Parameter></Parameters>
<ReferenceData><ReferenceItem><Key>QueueTimeoutURL</Key><Value>https://37.139.17.247:443/queryTimeout</Value></ReferenceItem></ReferenceData>
<Timestamp>'.$reqTime.'</Timestamp></Transaction>
<Identity>
<Caller>
<CallerType>'.$type.'</CallerType>
<ThirdPartyID>'.$spId.'</ThirdPartyID>
<Password>'.$password.'</Password>
<CheckSum></CheckSum>
<ResultURL>https://37.139.17.247:443/mpesaResult</ResultURL>
</Caller>
	<Initiator>
			<IdentifierType>11</IdentifierType>
			<Identifier>testguy</Identifier>
			<SecurityCredential>S7lS+m2xC8R5nqpji1rHMmnFOMK8VO62Gls/5Hll4vl6tybxxXT0167E8I60SnGfQPpkGsA4p6JZ1fG/8gmtz7/NSRxgp8G9gtYu95vRzuhCQbqgKpK8XCZydDibaCNpjFJB9+TCqWxYl//yqTEkhXKZDWCT3pDg21G1Bx1eFSP8V6YjTYRRJvNkQbZpgXmErmo+SHPLdi0X67WKIliB4WY+S2pb+EgA3Kxl2zUyBWoes2cq2/qVce+sg8bNEibDY12IqFKftkATxj76rhDBG/XDy6jvJfYZHwLf+7sxzk42MXvtOLWU3alBM60VlFpWQtbk8LdgtYQt/pBTUf7KzA==</SecurityCredential>
			<ShortCode>802805</ShortCode>
		</Initiator>
<PrimaryParty>
<IdentifierType>4</IdentifierType>
<Identifier>802805</Identifier>
</PrimaryParty>
<ReceiverParty>
<IdentifierType>1</IdentifierType>
<Identifier>254708374149</Identifier>
</ReceiverParty>
</Identity>
<KeyOwner>1</KeyOwner></request>]]></RequestMsg>
</s:Body>
</s:Envelope>';
        $curlData5 = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Header>
<h:RequestSOAPHeader xmlns:h="http://www.huawei.com.cn/schema/common/v2_1" xmlns="http://www.huawei.com.cn/schema/common/v2_1" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<h:spId>'.$spId.'</h:spId>
<h:spPassword>'.$real_pass.'</h:spPassword>
<h:serviceId>'.$SERVICEID.'</h:serviceId>
<h:timeStamp>'.$timestamp_.'</h:timeStamp>
</h:RequestSOAPHeader>
</s:Header>
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<RequestMsg xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<![CDATA[<request xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<Transaction>
        <CommandID>RegisterURL</CommandID>
<OriginatorConversationID>'.$originId.'</OriginatorConversationID>
        <Parameters>
            <Parameter>
                <Key>ResponseType</Key>
                <Value>Completed</Value>
            </Parameter>
        </Parameters>
        <ReferenceData>
           <ReferenceItem>
                <Key>ValidationURL</Key>
                <Value>https://37.139.17.247:443/mpesaResult</Value>
            </ReferenceItem>
<ReferenceItem>
                <Key>ConfirmationURL</Key>
                <Value>https://37.139.17.247:443/mpesaResult</Value>
            </ReferenceItem>

        </ReferenceData>
    </Transaction>

<Identity>
<Caller>
<CallerType>'.$type.'</CallerType>
</Caller>

<PrimaryParty>
<IdentifierType>1</IdentifierType>
<ShortCode>778879</ShortCode>
</PrimaryParty>
</Identity>
<KeyOwner>1</KeyOwner></request>]]></RequestMsg>
</s:Body>
</s:Envelope>';

		//
		$curlData2 = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:req=\"http://api-v1.gen.mm.vodafone.com/mminterface/request\">
<soapenv:Header>
<tns:RequestSOAPHeader xmlns:tns=\"http://www.huawei.com.cn/schema/common/v2_1\">
<tns:spId>107025</tns:spId>
<tns:spPassword>OWY2NTQ5MmFlYzliMjQ3ODlhMTEzNWM5NTkxZGUzOGE3ZTM1ZGUwNTdmOTNiZmY1ZTFhYTU3ODc2MDU2MGVkNA==</tns:spPassword>
<tns:serviceId>107025000</tns:serviceId>
<tns:timeStamp>20160202112822</tns:timeStamp>
</tns:RequestSOAPHeader>
</soapenv:Header>
<soapenv:Body>
<req:RequestMsg>
<![CDATA[<?xml version='1.0' encoding='UTF-8'?>
<Request xmlns=\"http://api-v1.gen.mm.vodafone.com/mminterface/request\">
	<Transaction>
		<CommandID>SalaryPayment</CommandID>
		<LanguageCode>0</LanguageCode>
		<OriginatorConversationID>167169_UMOJA_60333fe112383103322544</OriginatorConversationID>
		<ConversationID></ConversationID>
		<Remark>0</Remark>
		<Parameters><Parameter>
				<Key>Amount</Key>
				<Value>200</Value>
			</Parameter></Parameters>
		<ReferenceData>
			<ReferenceItem>
				<Key>QueueTimeoutURL</Key>
				<Value>http://37.139.17.247/mpesaResult</Value>
			</ReferenceItem></ReferenceData>
		<Timestamp>2016-02-02T11:28:22.000621Z</Timestamp>
	</Transaction>
	<Identity>
		<Caller>
			<CallerType>2</CallerType>
			<ThirdPartyID>broker_4</ThirdPartyID>
			<Password>ujildwljkd</Password>
			<CheckSum>null</CheckSum>
			<ResultURL>http://37.139.17.247/mpesaResult</ResultURL>
		</Caller>
		<Initiator>
			<IdentifierType>11</IdentifierType>
			<Identifier>testguy</Identifier>
			<SecurityCredential>S7lS+m2xC8R5nqpji1rHMmnFOMK8VO62Gls/5Hll4vl6tybxxXT0167E8I60SnGfQPpkGsA4p6JZ1fG/8gmtz7/NSRxgp8G9gtYu95vRzuhCQbqgKpK8XCZydDibaCNpjFJB9+TCqWxYl//yqTEkhXKZDWCT3pDg21G1Bx1eFSP8V6YjTYRRJvNkQbZpgXmErmo+SHPLdi0X67WKIliB4WY+S2pb+EgA3Kxl2zUyBWoes2cq2/qVce+sg8bNEibDY12IqFKftkATxj76rhDBG/XDy6jvJfYZHwLf+7sxzk42MXvtOLWU3alBM60VlFpWQtbk8LdgtYQt/pBTUf7KzA==</SecurityCredential>
			<ShortCode>802805</ShortCode>
		</Initiator>
		<PrimaryParty>
			<IdentifierType>4</IdentifierType>
			<Identifier>555661</Identifier>
		</PrimaryParty>
		<ReceiverParty>
			<IdentifierType>1</IdentifierType>
			<Identifier>254728355429</Identifier>
		</ReceiverParty>
		<AccessDevice>
			<IdentifierType>4</IdentifierType>
			<Identifier>1</Identifier>
		</AccessDevice>
	</Identity>
	<KeyOwner>1</KeyOwner>
</Request>]]></req:RequestMsg>
</soapenv:Body>
</soapenv:Envelope>";


        $curlData7 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<soapenv:Header>
<tns:RequestSOAPHeader xmlns:tns="http://www.huawei.com.cn/schema/common/v2_1">
<tns:spId>107015</tns:spId>
<tns:spPassword>OWY2NTQ5MmFlYzliMjQ3ODlhMTEzNWM5NTkxZGUzOGE3ZTM1ZGUwNTdmOTNiZmY1ZTFhYTU3ODc2MDU2MGVkNA==</tns:spPassword>
<tns:serviceId>107015000</tns:serviceId>
<tns:timeStamp>20160202112822</tns:timeStamp>
</tns:RequestSOAPHeader>
</soapenv:Header>
<soapenv:Body>
<req:RequestMsg>
<![CDATA[<?xml version=\'1.0\' encoding=\'UTF-8\'?>
<Request xmlns="http://api-v1.gen.mm.vodafone.com/mminterface/request">
<Transaction>
<CommandID>SalaryPayment</CommandID>
<LanguageCode>0</LanguageCode>
<OriginatorConversationID>167169_UMOJA_60333fe11238563103322544</OriginatorConversationID>
<ConversationID></ConversationID>
<Remark>0</Remark>
<Parameters><Parameter>
<Key>Amount</Key>
<Value>200</Value>
</Parameter></Parameters>
<ReferenceData>
<ReferenceItem>
<Key>QueueTimeoutURL</Key>
<Value>http://37.139.17.247:443/mpesaResult</Value>
</ReferenceItem></ReferenceData>
<Timestamp>2016-02-02T11:28:22.000621Z</Timestamp>
</Transaction>
<Identity>
<Caller>
<CallerType>2</CallerType>
<ThirdPartyID>broker_4</ThirdPartyID>
<Password>ujildwljkd</Password>
<CheckSum>null</CheckSum>
<ResultURL>http://37.139.17.247/mpesaResult</ResultURL>
</Caller>
<Initiator>
<IdentifierType>11</IdentifierType>
<Identifier>testguy</Identifier>
<SecurityCredential>S7lS+m2xC8R5nqpji1rHMmnFOMK8VO62Gls/5Hll4vl6tybxxXT0167E8I60SnGfQPpkGsA4p6JZ1fG/8gmtz7/NSRxgp8G9gtYu95vRzuhCQbqgKpK8XCZydDibaCNpjFJB9+TCqWxYl//yqTEkhXKZDWCT3pDg21G1Bx1eFSP8V6YjTYRRJvNkQbZpgXmErmo+SHPLdi0X67WKIliB4WY+S2pb+EgA3Kxl2zUyBWoes2cq2/qVce+sg8bNEibDY12IqFKftkATxj76rhDBG/XDy6jvJfYZHwLf+7sxzk42MXvtOLWU3alBM60VlFpWQtbk8LdgtYQt/pBTUf7KzA==</SecurityCredential>
<ShortCode>802805</ShortCode>
</Initiator>
<PrimaryParty>
<IdentifierType>4</IdentifierType>
<Identifier>802805</Identifier>
</PrimaryParty>
<ReceiverParty>
<IdentifierType>1</IdentifierType>
<Identifier>254708374149</Identifier>
</ReceiverParty>
<AccessDevice>
<IdentifierType>4</IdentifierType>
<Identifier>1</Identifier>
</AccessDevice>
</Identity>
<KeyOwner>1</KeyOwner>
</Request>]]></req:RequestMsg>
</soapenv:Body>
</soapenv:Envelope>';




        //experiment

        $url = "https://196.201.214.137:18423/mminterface/registerURL";
//        $url = 'https://196.201.214.136:18423/mminterface/request';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
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
        curl_setopt($curl, CURLOPT_SSLCERT, '/var/www/server-mobibeta-readable.pem');
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');

//curl_setopt($curl, CURLOPT_SSLKEY, '/var/www/html/sdp_apps/services/b2c/pkcs/certs_chain.pem');
        curl_setopt($curl, CURLOPT_SSLKEY, '/var/www/server.key');
        //curl_setopt($curl, CURLOPT_SSLKEYPASSWD, '');

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlData5);
        //curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'read_header'); // get header

        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Curl Error: ' . curl_error($curl) . "\n\n";
        }

        echo date('Y-m-d H:i:s') . ": Response: $result\n";
        curl_close($curl);

//$xml = new SimpleXMLElement($result);
//print_r($xml);

        function read_header($curl, $string) {
            print "Received header: $string\n\n";
            return strlen($string);
        }
        exit;
    }

    public function getSecurityCredential($source){

        $crypttext;
        $padding = "OPENSSL_PKCS1_PADDING";
        $fp=fopen("/var/www/mobibeta/app/Http/Controllers/apicrypt.safaricom.co.ke.cer","r");
        $pub_key=fread($fp,8192);
        fclose($fp);
        $pub_key_string=openssl_get_publickey($pub_key);
        openssl_public_encrypt($source,$crypttext,$pub_key_string);
        /*this simply passes the string contents of pub_key_string back to be decoded*/
        $test = base64_encode($crypttext);
        return $test;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
