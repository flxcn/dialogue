# TODO

- Write PHP function or jQuery AJAX function to update the number of committee members; or do a array.size() on the data for the getDelegatesInCommittee jQuery function and insert that number into the pill badge next to "Committee Delegates"

- Make sure session is updating correctly; write jQuery function to constantly update last_active_on

- Once messages are set up, uncomment line 36 on [get-delegates-in-committee.php](/delegate/get-delegates-in-committee.php)

- Write Profile page

- Decide which color scheme works best for messages box; grey or white boxes for the other person, blue for this person?

- Add link to [register.php](/delegate/register.php) on the sign-in page, preferable under the sign in button

- Consider switching out the logo, if necessary. 64px by 64px is current size

# COMPLETED

- Figure out POST AJAX JQuery

# NOTES/LEARNING

- Don't need to json_decode data sent from jQuery POST function to PHP, can just use $_POST['var_name']

- data: {var1_name: var1_name, var2_name: var2_name} is proper format for jQuery POST function param. Don't concatenate together a string like a URL

- can define JS variables with PHP session data in the script on dashboard.php, which are then accessible in the dashboard.js jQuery file

- make sure not to misspell 'committee' for it is easy to forget the second 't' when typing fast