delegates table

delegate_id         | primary int(11) NOT NULL
delegate_name       | varchar(250) NOT NULL
email      | varchar(250) NOT NULL
password   | varchar(100)
status     | bool NOT NULL // disabled or enabled
created_on          | timestamp NOT NULL
is_logged_in        | bool


