# activecollab-smartcard-authentication

https://www.activecollab.com/


## VERSION HISTORY

2010 04 22 (latest) - Works with latest ActiveCollab, version 2


## INSTALLATION STEPS

- svn export https://activecollab-smartcard-autentication.googlecode.com/svn/trunk/ activecollab-smartcard-autentication
- cp -a ./activecollab-smartcard-autentication/activecollab/`*` YOUR_ACTIVECOLLAB_INSTALLATION_DIR
- Add to your YOUR_ACTIVECOLLAB_INSTALLATION_DIR/config/config.php line:   `define('AUTH_PROVIDER', 'IDCardAuthenticationProvider');`
- Change file activecollab/angie/classes/smarty/plugins/function.select_im_type.php row 11 to $im_types = array('SERIAL_NUMBER or smth else :)');
- Add client sertificate request to apache conf:


```
# this is under virtualhost :443 section
# your webserver public and private cert
SSLCertificateFile    /etc/ssl/certs/www.domain.ee.crt
SSLCertificateKeyFile /etc/ssl/private/www.domain.ee.key
# This makes certain, that its valid smartcard and is allowed (google for ID kaart + apache server)
SSLCACertificateFile /etc/ssl/certs/id.crt
# request client cert
SSLVerifyClient require
SSLVerifyDepth 2
SSLOptions +StdEnvVars +ExportCertData
```

(Instead first step - creating export from svn, you can also download .zip from under Downloads and extract it.)

## HOW TO ALLOW LOG IN WITH ID CARD TO USER

- Add user
- Mark as his Instant Messanger value his Serial from Smartcard (isikukood)
- Voilaa


## HOW IT WORKS

It extends ActiveCollabs Basic autentication, and should be working also after upgrades etc (if application API used function will not change - most problaby it will not so much.)

Basically it was ment for Estonian ID card users, but it should be possible to use with any Smartcard. 

If your value against what your would like to check is not in certificate.subject.serialNumber, you only have to change `IDCardUsers.php.class findBySerial($serial)` method and `IDCardAuthenticationProvider.class.php authenticate($credentials)` method.

I have used BasicAuthProvider etc classes, changed and extended them a bit (you may notice, that some of the used classes comments are even seen in this code) - so not much work on my part, approx 30 lines written from me to add Smartcard auth.


## USING SMARTCARD SOLVES FOLLOWING PROBLEMS

- With Smartcards its much harder (if not impossible) to fake identy
- Users do not have to remember their passwords on different infosystems


## AUTHOR

Margus Pärt (mxrguspxrt)
