messages table

message_id  | primary, int(11), NOT NULL
sender_id | int(11), NOT NULL
reciever_id
message_content | varchar(500), NOT NULL
created_on  | timestamp
is_verified | bool, default: FALSE (0)