# FurezApi
FurezApi Framework is a quick tool to exploit file upload vulnerability

## What's FurezApi Framework ?
FurezApi Framework will allow you to exploit file upload vulnerability on website server. The main goal is pretty simple : Test every possibilities of infected files to upload, if the upload is successful; 
- giving you a user interface to manage datas
-	allowing you to do what you want to do on server.

Show the folder structure of the website ? Show a specific file ? Zip content ? Download content ? Upload or even delete ? If the API succeed to be upload on the server. You're the new king of this one!

Thanks to Furez's structure you can easily create your own bundle in order to complete the work.

+ SQL connexion and request through the API will allow you to quickly obtain data from a database but with the connexion of the server. (Leave no trace of your connexion)

## Technology ?
FurezApi Framework use web languages for the interface and the infected API witch includes : PHP, Js and HTML,CSS.
The future automated program will use Python to make it even quicker.

## Framework ?
For the front we got 3 frameworks : Twitter Bootstrap (to get a quick look), Font Awesome (to get some nice icons) and jQuery.
On the back side we got AltoRouter to get a simple and lightweight routing system.

## Current Version ?
1.0

### What's in progress before release ?
- Better handle of responses and displays of errors
- All possibilities of infected API in testing directory
- Python Automatisation (with GUI thanks to GALA)

### If you encounter problems?
- Check your rights on the files and folder.. Can you display, read and write on file or folder ? (ls -l)
- Check your Apache configuration.. Check if the rewrite mod is enabled, Allow Overrid All, etc ..
- Check your php.ini: allow_url_fopen ? curl ? 
- If you find any other bug, you can post it on this git hub. Then a fix will be added.

## Quick Install :
1. Pull the project in your localhost directory (/var/www/html on linux or directory htdocs on windows) :--
`git clone https://github.com/LeaklessGfy/FurezApi.git`

2. Install vendor --
`composer install`

3. Define your api_config.xml --
`cd furezapi/config`
`cp api_config.xml.dist api_config.xml`

4. Edit your api_config.xml with your setting --
In order to define your routes : go line 4 of api_config.xml and edit your basepath.
If index.php is accessible at : localhost/furez/index.php
Your basepath is : /furez

5. Go on the app and define api url --
Now launch your localhost go to the url and define the url of your API in config page

