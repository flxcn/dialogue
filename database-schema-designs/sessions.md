sessions table

table_column    | data type
----------------|--------------------------------------------
session_id      | primary int(11) NOT NULL
delegate_id     | primary int(11) NOT NULL
<!-- can we make delegate_id a foreign key? Could be good for performance, more indexes -->
last_active_on  | timestamp, default: CURRENT_TIMESTAMP
    <!-- the most recent timestamp the delegate was active (dashboard browser session was open), used for determining Offline vs Online status -->

<!-- is_typing  | whether a delegate is currently typing -->
<!-- Not necessary at this time, it will not be included. -->

