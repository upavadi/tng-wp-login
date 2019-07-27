# **Wordpress-TNG Login Widget** # 

## Download ##
There is no download version. 
(under Development)

## License ## 
The code is licenced under the [MIT licence](http://opensource.org/licenses/MIT)

## Introduction
This widget is designed to replicate the Wordpress login/log out task and also logs into TNG ( The Next Generation of Genealogy Sitebuilding )](http://www.tngsitebuilding.com/).

Log In: User may login using UserName or User Email. If UserName exists in TNG database, user is also logged into TNG.

Password Reset: Wordpress Password-Reset 

#### WP-TNG Integration ####
Integration is achieved by displaying TNG content within Wordpress wrapper. There are 2 main methods of acheiving this.

- CK Method: Replacing TNG Header and footers by Hard coding topmenu.php, footer.php and meta.php
    -  The widget works very well with the CK method
* MB Method: A plugin by Mark Barnes creates a Wordpress 'Post' to display TNG content within Worpress header.

    * At the moment, I am having problem getting it work consistently with MB Method. The plugin uses pseudo wordpress page to display TNG. I am having issues of WP-TNG Login widget work consistently with these pseudo redirects. .
 

issue
Tng page needs refrash to see login success.





#### The Widget has several useful features:
 - Simple access to the TNG database from within Wordpress.
 - A convenient collection of shortcodes and functions for integrating TNG data into your Wordpress site.
 -	A convenient way for users to submit data-additions and data-changes
 -	A convenient way, for the administrator, to check and update TNG database from within Wordpress.
 - A convenient way, for the user, to upload default photo from the person page
 -	A convenient way, for the user, to upload media and update media links
 -	A custom shortcode directory, with a sample shortcode, to help you create and store your own custom shortcodes.







### Developed on TNG V10.1.3 and Wordpress V 4.9 - 5.1 platform.
### Tested PHP V 5.4 - 5.5, Wordpress 4.9 - 5.1 

# Registrtion
### If submitted User Name User Name is in WP or TNG  database and  submitted email is not, error 'User Name in use' is generated.
### If sumbmitted email is in WP or TNG  database, user is requested to Try Password Reset.
### Just one field, 'tng_interest' is added by this plugin in 'wp_usermeta' table. This field is used in New Registration Submission. 

## Login
### Logging in to Wordpress with user name or user email
### If login to Wordpress is successful, user is logged in to TNG


# Profile 

## Profile
### Profile
### Profile
##### Profile
