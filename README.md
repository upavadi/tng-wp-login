# **Wordpress-TNG Login Widget** # 

## **Download**
Release version 1.0.4 https://github.com/upavadi/tng-wp-login/releases/latest has been updated with V2.0.Beta

 - version 2.0.Beta is under going test in
 - ***Test Site:*** http://trial.upavadi.net/ site uses M Barnes plugin for wordpress / TNG integration
 - ***Live Site:*** http://www.upavadi.net/   site uses Kloosterman method for wordpress / TNG integration
 - On both sites, Wordpress and TNG are installed in their own folders.

-----

## **License**
The code is licenced under the [MIT licence](http://opensource.org/licenses/MIT)

------------

## **Introduction**
This widget replicates the Wordpress login/log out task and also logs into TNG, [The Next Generation of Genealogy Sitebuilding](http://www.tngsitebuilding.com/).
- Adds a Registration Form which may replace the Wordpress registration form by deselecting 'Membership>Anyone can register' in Wordpress Dashboard>Settings.
- Adds a User Profile page which saves the changes in Wordpress and TNG database
- Adds an enhanced Password-Reset module which checks for the presence of email of registered user.
- Almost all the text used in pages and emails is customisable by the administrator.
- ### **User may login using either registered user Name or email**. On successful login, if User Name exists in TNG database, the user is also logged in to TNG.
- GDPR Privacy policy is implemented
---------------------
## **Compatibility**
- The plugin is under Final Beta Test and tested on TNG 9.1, 10.1.3 and 12.2.1
  - database changes made to TNG 11.x are allowed for. My thanks to [Darrin](http://www.tngsitebuilding.com/) for supplying details.
- PHP version 5.4 - 7.3
-  Wordpress V 4.9 - 5.2.2 platform
- A Wordpress twenty Twelve child theme. (Not tested in any other theme).

------------------------

## **Issues**
**WP-TNG Integration** is achieved by displaying TNG content within Wordpress wrapper. 
To my knowledge, there are 2 main methods available for achieving this.
Works well with TNG V 9 - 10 and 12. Changes in V11 implemented but have not been tested.
1. **Mark Barnes method** (MB-Method) uses a plugin to replace WP page with TNG content.
Only known issue is that the WP-TNG integration plugin seems to deactivate TNG Login panel so that User cannot login to TNG using TNG Login Panel. This should not be a problem because user may login by using WP_TNG Login.
My Test site is using this method with TNG V10.   
   - ***If using this method, deselect "Integrate TNG/Wordpress logins: " option.*** 
2. **Cees Kloosterman Method** (CK-Method) uses customized Header and Footer files by replacing TNG Header and footer by Hard coding topmenu.php, footer.php and meta.php, in TNG folder. This is a very simple and effective method and I have now converted my live site CK-Method.
3. ***The plugin is also tested with TNG V12, on my local server using both integration methods***  
4. **Page Refresh** ~~may be required~~ to see successful TNG login. 
4. **Send email** uses Worpress mail. It is possible that emails do not work if you have SMTP mail enabled in Wordpress. Please let me know if this is an issue.
--------------

## **Change Log **
 - Current version 2.0.Beta
  - Check to see if TNG configuration files have been moved
  - Checks made for TNG Vesion 11 and 12 to cater for DB changes
  - changes to cater for MYSQL 5.7 strict mode
  - added Consent flag for new user - this will also apply to Wordpress
  - added ask-consent flag for existing users if not present
  - Add consent flag in Wordpress to database
  - Add optional generic cookie info under login banner. Text customisable
  - Add privacy management menu in Admin WP_TNG Login
    - Exclude Admin from consent challange 
  - Trap Fatal PHP errors when it cannot find TNG folder 
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

 - ***Please note that you may get PHP warnings, if debug is active,  complaining that it canno find subroot.php in TNG folder. Navigate to the bottom to see the prompt***
------------------------------
## **New Registration Form**
  A link to registration form is included in the login widget.
 - **On submission, submitted user name and user email is checked against WP and TNG user details.**
 - If New User Consent is enabled, submitter is asked to give consent before new registration is accepted.
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
   - **Privacy and Consent**
     - Enable consent for new user (Track TNG setting if avalable)
     - Edit User consent agreement Text
     - Seek Consent from existing User
     - Edit consent agreement Text for existing user
     - Enable Cookie Approval Message (Track TNG setting if avalable)
     - Edit Cookie Message
     - Show link to Data Protection Policy (Track TNG setting if avalable)
     - Use TNG document or your own customized document
------------------     
## **Privacy**
**TNG V12 Introduces privacy policy and this plugin will track TNG settings. For V 9 - 11, privacy policy can still be implemented**
 - Privacy settings can be accessed from Admin Dashboard>WP-TNG Login>Privacy
 - On first activation, visit the privacy panel
  - If you are using TNG Version 12, panel will display the 3 privacy settings in TNG and appropriate checkbox(s) checked below. I suggest you leave the default checkbox settings as they are. Any change to these 3 settings shoud be done in TNG admin panel. After every change in TNG, revisit this panel and save the changes.
   - if you are using TNG Version 9, 10 or 11, you may still use the the settings. Only difference would be notification of Cookies which is described below, under cookies.
 - **The options:**  
   - **Enable User Consent regarding personal info**
     - tracks V12 setting, ***Prompt for consent regarding personal info.*** 
       - New user registration: User is asked to give consent to store personal information.
       - Text for this is in ***User consent agreement Text***
       - Prompt to notify user that they must give consent is in ***Prompt for consent agreement.***
       - User registration is completed when this agreement is accepted.
   - **Show link to data protection policy** 
     - tracks V12 setting,***Show link to data protection policy***
       - You have an option of using either
         - TNG Privacy Document or
         - your own document (I already had Wordpress before upgrade to V12. So I use this page)
       - You would need to enter appropriate URL in ***URL for Document Location***. I have provided some some prompts below the text area. 
       - New user has an option of viewing the Privacy-policy before giving consent.  
   - **Show Cookie Message for anonymous visitor**
     - tracks V12 setting, ***Show cookie approval message*** .  
     - I have had a good think about this and after taking advice I came to the conclusion that session cookies are not that bad. As long as visitor is informed, in the privacy docunment that the site uses session cookies, that should suffice. 
     - When anonymous visitor visits
       - Wordpress does not save any session cookies
       - TNG V9, 10 or 11 do not save any session cookies
       - TNG v12 saves a PHPID cookie and if ***Show cookie approval message*** is enabled, a pop-up stating site uses cookies and accept option. If accepted, TNG places and identifier cookie.
     - **So this is what I have decided to do.**
       When ***Show Cookie Message for anonymous visitor*** is checked
       - When an anonymous visitor comes to the site, a banner below the login panel shows that the site uses cookies.
       - The banner goes away as soon as visitor logs in.
       - Text for the banner (best keep it short) is entered in ***Cookie Message***
       - If TNG V12 is in use, all thg pages will display TNG cookie popup until the pop-up is ackowledged.          
 
  - **There is an additional option**
   - Seek Consent from existing User: This allows you to seek consent from existing users who have not given consent before. User is only logged in if consent is given. Text for the content is entered in text area, **Prompt for Logged In User Consent**. You may also add that site uses cookies.
 -----------------------------
## Please let me know if there are any bugs or you have any suggestions ##
 ------------------------------
***Current release version 2.0.1. I look forward to your feedback on any issues.***
--




