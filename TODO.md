# TODO

- Write PHP function or jQuery AJAX function to update the number of committee members; or do a array.size() on the data for the getDelegatesInCommittee jQuery function and insert that number into the pill badge next to "Committee Delegates"

- Make sure session is updating correctly; write jQuery function to constantly update last_active_on

- Once messages are set up, uncomment line 36 on [get-delegates-in-commitee.php](/delegates/get-delegates-in-commitee.php)

- Write Profile page

# COMPLETED

- Figure out POST AJAX JQuery

# NOTES/LEARNING

- Don't need to json_decode data sent from jQuery POST function to PHP, can just use $_POST['var_name']

- data: {var1_name: var1_name, var2_name: var2_name} is proper format for jQuery POST function param. Don't concatenate together a string like a URL

- can define JS variables with PHP session data in the script on dashboard.php, which are then accessible in the dashboard.js jQuery file