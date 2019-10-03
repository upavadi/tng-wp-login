# **Wordpress-TNG Login Widget** # 
* (In current version, Registration  may fail with TNG V12.x because of Database changes. ) *
## **Download**
Download current release version 1.0.4 https://github.com/upavadi/tng-wp-login/releases/latest

 - Current version is in use
 - http://trial.upavadi.net/ site uses M Barnes plugin for wordpress / TNG integration
 - http://www.upavadi.net/   site uses Kloosterman method for wordpress / TNG integration

-----

## **License**
The code is licenced under the [MIT licence](http://opensource.org/licenses/MIT)

------------

## **Introduction**
This widget replicates the Wordpress login/log out task and also logs into TNG ( The Next Generation of Genealogy Sitebuilding )](http://www.tngsitebuilding.com/).
- Adds a Registration Form which may replace the Wordpress registration form by deselecting 'Membership>Anyone can register' in Wordpress Dashboard>Settings.
- Adds a User Profile page which saves the changes in Wordpress and TNG database
- Adds an enhanced Password-Reset module which checks for the presence of email of registered user.
- Almost all the text used in pages and emails is customisable by the administrator.
- User may login using either registered user Name or email. On successful login, if User Name exists in TNG database, the user is also logged in to TNG.
---------------------
## **Compatibility**
- The plugin is under Beta Test and is tested on TNG 10.1.3
- PHP version 5.4 - 5.6.40
-  Wordpress V 4.9 - 5.2.2 platform
- A Wordpress twenty Twelve child theme. (Not tested in any other theme).

------------------------

## **Issues**
**WP-TNG Integration** is achieved by displaying TNG content within Wordpress wrapper. 
To my knowledge, there are 2 methods available for achieving this.

1. **Mark Barnes method** (MB-Method) uses a plugin to replace WP page with TNG content.
~~At the moment, this plugin has some conflicts with displaying TNG media and the issue is not resolved.
Not tested with this plugin.~~
It is possible that there may be some conflicts with the Theme in use.
If using this method, deselect "Integrate TNG/Wordpress logins: " option. 
2. **Cees Kloosterman Method** (CK-Method) uses customized Header and Footer files by replacing TNG Header and footer by Hard coding topmenu.php, footer.php and meta.php, in TNG folder. This is a very simple and effective method and I have now converted my live site (and Beta test site) from MB-Method to CK-Method. The plugin is tested using this integration method.
3. **Page Refresh** ~~may be required~~ is required to see successful TNG login. 
--------------

## **Change Log **
 - Current version 1.0.4
 ------------

## **Activation**
On activation, 
 - plugin inserts following pages if they do not exist. 

Wordpress (WP) Page | Slug | Shortcode 
---------------|------|----------
Registration   | 'wp-tng-registration'|[user_registration] 
Profile        |  'wp-tng-profile'    |[user_profile]
Password Reset |'wp-tng-resetPassword'|[reset_Password_form]
Password Lost  | 'wp-tng-lostPassword'|[lost_Password_form]

- Plugin checks for the path to TNG folder. If it cannot locate the folder, administrator is prompted to submit TNG Root (absolute) Path  and if tng folder is found, plugin is activated. 
------------------------------
## **New Registration Form**
  A link to registration form is included in the login widget.
 - **On submission, submitted user name and user email is checked against WP and TNG user details.**

On successful submission,
 - New registrations are entered in WP and TNG User tables.
 - In TNG,  user awaits Review (TNG>Admin Panel>User>Review Tab).
 - In WP, user is allocated 'Subscriber' role.

 - Note: I allocate Contributor (or above) role to all my users. 
   - Subscriber role does not have any privilages.
   - For this to be effective, I deselect Membership> Anyone can register in WP Dashboard>Settings. 
  - New user receives an email generated by the plugin.
  - Email is sent to Administrator for new registrations, password reset alerts.
  - If there is an anamoly in data, email is sent to administrator with details of the data held.
  - Text for screen alerts and email can be configured, by the administrator.

   - **Recaptcha V2** can be used by entering public & private keys and enabling recaptcha in dashboard panel>WP-TNG-Login> Captcha keys.
  - If you have recaptcha V3 installed then there is no need to enable V2.

 Submission  | Response | Action | Comment
 ------------|----------|--------|---------
 user name and email not in either database|Alert Title: 'New Registration Success'|enter user in both databases| New Registration Success email to new user and copy to administrator
 Submitted User Name is in WP and/or TNG  database and  submitted email is not in either DB|Error Title: user name in use| new user name expected| Check new credentials
submitted email in WP|Alert Title: Suggest password reset|Expect Submitter to click on *Reset My Password'* button|email administrator with credentials held in both databases
submitted email in TNG DB only|Alert Title: 'We Shall Contact You'| administrator will have to action|email administrator with credentials held in both databases

-------------------



## **Password Reset**
 - Some WP Password-Reset routines are re-written. 
 -  Password reset is only allowed if the submitted email is in WP database. 
 - If the submitted email is in TNG database only, email is sent to administrator with credential details and submitter is requested to await a response from the administrator.
-------------------------
 ## **Profile Page**
 WP user page is not easily available so this profile page may come in useful. 
 - On successful login, 
   - if user is an administrator, link to Dashboard is shown
   - otherwise a link to Profile page shown. Text for this can be edited in admin panel.
 - Here user can  make changes to user data, including password, and data is saved in WP and TNG database.
 - If user has default phot specified in TNG, this will be displayed here.  

------------------
## **Customized Text**
**All text is held in config.json file and can be edited by going to admin panel and accessing via admin-menu.**
- **WP-TNG-Login**
  - **Plugin Paths**: 
    - Enter TNG absolute path, Tng URL and Name of TNG photo folder
  - **Login Text:** 
    - Enter text for Greeting, user page and slug names for profile and registration   
  - **Captcha Keys** 
    - enter Public and Private Keys
    - Enable Captcha
  - **Profile Page** 
    - Here you can control the text of all the labels
    - Enable/disable additional interest fields
  - **Registration Page**    
    - Here you can control the text of all the labels
    - Enable/disable *additional interest* fields
  - **Registration Messages** 
    - Registration Success Message 
    - New Registration email
    - Email in TNg only - anamoly
    - Introduction text (Appears before Reg Form) 
      - Enable Intro Text
   - **Password-Reset Messages** 
     - Text for Suggest Password Reset to New Registration
     - Text for Forgot Your Password
     - Text for Lost Password email
------------------------
**Current release version 1.0.4. I look forward to your feedback on any issues.**



