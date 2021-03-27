# TODO

- Write PHP function or jQuery AJAX function to update the number of committee members; or do a array.size() on the data for the getDelegatesInCommittee jQuery function and insert that number into the pill badge next to "Committee Delegates"

- Make sure session is updating correctly; write jQuery function to constantly update last_active_on

- Once messages are set up, uncomment line 36 on [get-delegates-in-committee.php](/delegate/get-delegates-in-committee.php)

- Write Profile page

- Decide which color scheme works best for messages box; grey or white boxes for the other person, blue for this person?

- Add link to [register.php](/delegate/register.php) on the sign-in page, preferable under the sign in button

- Consider switching out the logo, if necessary. 64px by 64px is current size

- Make the delegate button change color and switch to active if selected Could start with a button first

# COMPLETED

- Figure out POST AJAX JQuery

# NOTES/LEARNING

- Don't need to json_decode data sent from jQuery POST function to PHP, can just use $_POST['var_name']

- data: {var1_name: var1_name, var2_name: var2_name} is proper format for jQuery POST function param. Don't concatenate together a string like a URL

- can define JS variables with PHP session data in the script on dashboard.php, which are then accessible in the dashboard.js jQuery file

- make sure not to misspell 'committee' for it is easy to forget the second 't' when typing fast

- .html() for html only, .load() for external files as well

# USEFUL LINKS

## jQuery, AJAX, w/ PHP

- jQuery on external page https://stackoverflow.com/questions/6079811/jquery-not-working-in-external-javascript

- jQuery POST method 
    - w3schools https://www.w3schools.com/jquery/ajax_post.asp
    - tutorialsTeacher https://www.tutorialsteacher.com/jquery/jquery-post-method

- AJAX Button click example: could be good for clicking on the delegate and switching the message box. Maybe storing that current delegate being spoken to into a session variable. https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_ajax_ajax_async

- jQuery .ajax w3schools: https://www.w3schools.com/jquery/ajax_ajax.asp

- Full list of jQuery AJAX methods: https://www.w3schools.com/jquery/jquery_ref_ajax.asp

- jQuery .load method w3schools: https://www.w3schools.com/jquery/jquery_ajax_load.asp

- First answer has a good error handle example: https://stackoverflow.com/questions/8753714/jquery-typeerror-undefined-is-not-a-function-on-ajax-submit

- https://www.cluemediator.com/ajax-post-request-with-jquery-and-php#hpdipf

- First answer, important three statements to end the PHP AJAX handler file, to return data as JSON: https://stackoverflow.com/questions/7064391/php-returning-json-to-jquery-ajax-call

- How to count the number of entries in a JSON https://stackoverflow.com/questions/36648714/how-can-i-count-of-responses-in-jquery-ajax-result

----------------------------------------------------------------
## Bootstrap, CSS

- Bootstrap 4, understanding padding, margins, etc. UTILITIES: https://www.w3schools.com/bootstrap4/bootstrap_utilities.asp

- How to center a column, but not necessarily all the text inside it: https://stackoverflow.com/questions/35163164/how-to-center-content-in-a-bootstrap-column

- How to freeze a button after being clicked https://stackoverflow.com/questions/57833670/how-to-disable-a-button-after-clicking-it-and-enable-it-after-the-login-process

- Make a list item clickable https://stackoverflow.com/questions/3486110/make-a-list-item-clickable-html-css

- Bootstrap colors https://www.w3schools.com/bootstrap4/bootstrap_colors.asp