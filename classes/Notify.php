<?php
    class Notify {
    	public static function createNotify($type, $senderId, $receiverId, $extra = 0, $text = "") {
            $messageId = $extra;
            $postId = $extra;
            $commentId = $extra;
            $pollId = $extra;
            $timeZone = "America/New_York";
            $timeStamp = time();
            $dateTime = new DateTime("now", new DateTimeZone($timeZone));
            $dateTime->setTimestamp($timeStamp);
            // Create notification when a user follows you
            if($type == "follow") {
                Database::query("INSERT INTO notifications VALUES (:id, :type, :sender, :receiver, :extra, :d8)", array(":id"=>null, ":type"=>$type, ":sender"=>$senderId, ":receiver"=>$receiverId, ":extra"=>"", ":d8"=>$dateTime->format("m-d-y, h:i:s A")));
            }
            // Create notification when a user messages you
            else if($type == "inboxMessage") {
                Database::query("INSERT INTO notifications VALUES (:id, :type, :sender, :receiver, :extra, :d8)", array(":id"=>null, ":type"=>$type, ":sender"=>$senderId, ":receiver"=>$receiverId, ":extra"=>$messageId, ":d8"=>$dateTime->format("m-d-y, h:i:s A")));
            }
    	}
        public static function deleteNotify($type, $senderId, $receiverId, $extra = 0, $text = "") {
            $postId = $extra;
            $commentId = $extra;
            $pollId = $extra;
            // Delete notification created when a user follows you
            if($type == "follow") {
                Database::query("DELETE FROM notifications WHERE type=:type AND sender=:sender AND receiver=:receiver", array(":type"=>$type, ":sender"=>$senderId, ":receiver"=>$receiverId));
            }
        }
    }
?>