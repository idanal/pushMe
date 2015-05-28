#gen
openssl pkcs12 -clcerts -nokeys -out cert.pem -in Certificates.p12
openssl pkcs12 -nocerts -out key.pem -in Certificates.p12
openssl rsa -in key.pem -out key.unencrypted.pem
cat cert.pem key.unencrypted.pem > ck.pem

#clear
rm cert.pem
rm key.pem
rm key.unencrypted.pem
