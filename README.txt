Setup ssl certificate

copy cacert.pem to php_folder\extras\ssl folder
modify next line in php.ini
; curl.cainfo
to
; curl.cainfo = "php_folder\extras\ssl\cacert.pem"

Scripts

validicupdate.bat
Import and conver all users activities from Validic to Leon.
Programmed in operating system to be executed in a time interval.

Documentation

validicupdatedoc.bat
Create code documentation. 
