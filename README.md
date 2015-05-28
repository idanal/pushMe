# pushMe

此项目包含两个脚本，用于帮助你快速的使推送运作起来。

This git help you make apns work efficient.

There are 2 key scripts:

1.gen_pem.sh - Used to generate ck.pem. 用于生成ck.pem。

2.pushMe.php - Used to push a test message. 用于推送测试消息


# Usage:

1.Export your Development or Distribution certificates as Certificates.p12 from Keychain

2.Run gen_pem.sh in console to generate ck.pem file.(Make sure the p12 file saved in the same directory)

3.Open pushMe.php, modify the deviceToken and passphrase

4.Enter this command in console to push a message: php pushMe.php

5.Have fun with it!
