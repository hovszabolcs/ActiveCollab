#/bin/sh
openssl genrsa -out web.key 2048
# csr
openssl req -new -key web.key -out web.csr -config openssl-san.cnf
# Sign cert with CA - common name and email must be different than CA
openssl x509 -req -in web.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out web.crt -days 365 -sha256 -extfile openssl-san.cnf -extensions req_ext
cat web.crt ca.crt > fullchain.crt
openssl verify -CAfile ca.crt web.crt
openssl verify -CAfile fullchain.crt web.crt