delegates table

table_column    | data type
----------------|--------------------------------------------
delegate_id     | primary int(11) NOT NULL
first_name      | varchar(50) NOT NULL 
    <!-- real first name of the delegate attending the conference-->
last_name       | varchar(50) NOT NULL
    <!-- real last name of the delegate attending the conference-->
representation  | varchar(50) NOT NULL
    <!-- who the delegate is representing - could be a country (e.g. USA) or character (e.g. LBJ) -->
username        | varchar(50) NOT NULL
    <!-- email address of delegate, used as a username in sign-in process -->
school          | varchar(50)
    <!-- the delegate's school, can be null if they are independent -->
committee_id    | int(11) NOT NULL 
    <!-- the numerical id of the committee this delegate is participating in -->
conference_id   | int(11) NOT NULL 
    <!-- the numerical id of the current conference (for now should be '1', because only LakeMUN)-->
password        | varchar(250), NOT NULL
    <!-- hashed password for the account -->
is_enabled      | bool NOT NULL, default: TRUE
    <!-- whether the account is enabled (i.e. allowed to access). If it is false, the account is disabled -->
created_on      | timestamp NOT NULL, default: CURRENT_TIMESTAMP
    <!-- the timestamp of when the delegate account was created-->
last_active_on  | timestamp, default: CURRENT_TIMESTAMP
    <!-- the most recent timestamp the delegate was active (dashboard browser session was open), used for determining Offline vs Online status -->


