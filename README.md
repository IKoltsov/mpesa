#Laravel 5 Package for B2C Mpesa G2 Negotiation

composer require leyo/mpesa

#Add Service provider

leyo\Mpesa\MpesaServiceProvider::class

composer dump-autoload
#MPESA Configs

From the root:

sudo nano .env


//Add the following configs as per your Mpesa API settings


SPID=SPID
PASSWORD =PASSWORD
SERVICEID=SERVICEID
initiator_username=initiator_username
initiator_pass=initiator_pass
B2CPaybill=B2CPaybill
result_url=result_url
SSL_CERT_PATH=SSL_CERT_PATH
SSL_KEY_PATH=SSL_KEY_PATH
SSL_PASS=SSL_PASS
APICRYPT_PATH=APICRYPT_PATH