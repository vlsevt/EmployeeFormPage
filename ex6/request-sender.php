<?php

require_once 'socket.php';


$request = "POST /~makalm/icd0007/foorum/?cmd=delete&id=7631&username=vlsevt-icd HTTP/1.1
Host: enos.itcollege.ee
Content-Type: application/x-www-form-urlencoded
Content-Length: 0
X-Secret: 123456
Cookie: PHPSESSID=id755167nukjr5e1npels8iv3c

";


$request = "GET /~makalm/icd0007/foorum/?message=deleted&username=vlsevt-icd&key=e372810214 HTTP/1.1\r\nHost: enos.itcollege.ee\r\nCookie: PHPSESSID=id755167nukjr5e1npels8iv3c; path=/\r\n\r\n";


print makeWebRequest("enos.itcollege.ee", 443, $request);


