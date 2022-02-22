<?php
class Friend{
    
    protected $db;

    public function __construct($db_connection){
        $this->db = $db_connection;
    }

    // MAKE PENDING FRIENDS (SEND FRIEND REQUEST)
    public function fri_request($my_id, $user_id,$time){
    
        try{

            $stmtcheck = $this->db->prepare("SELECT * FROM friend_request WHERE (sender = :my_id AND receiver = :frnd_id) OR (sender = :frnd_id AND receiver = :my_id)");
            $stmtcheck->bindValue(':my_id',$my_id, PDO::PARAM_INT);
            $stmtcheck->bindValue(':frnd_id', $user_id, PDO::PARAM_INT);
            $stmtcheck->execute();
            $result = $stmtcheck->fetch(PDO::FETCH_ASSOC);

            if($result){
              exit;
            }else{
                $sql = "INSERT INTO `friend_request`(sender, receiver,req_state,time) VALUES(?,?,0,'$time')";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$my_id, $user_id]);
            }


            exit;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // CANCLE FRIEND REQUEST
    public function cancel_friend_request($my_id, $user_id){
    
        try{
            $sql = "DELETE FROM `friend_request` WHERE (sender = :my_id AND receiver = :frnd_id) OR (sender = :frnd_id AND receiver = :my_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':my_id',$my_id, PDO::PARAM_INT);
            $stmt->bindValue(':frnd_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            
            $stmtCheckFriList = $this->db->prepare("SELECT rskey FROM friends WHERE (user_one = :user_one AND user_two = :user_two) OR (user_one = :user_two AND user_two = :user_one)");
            $stmtCheckFriList->bindValue(':user_one',$my_id, PDO::PARAM_INT);
            $stmtCheckFriList->bindValue(':user_two', $user_id, PDO::PARAM_INT);
            $stmtCheckFriList->execute();
            $result = $stmtCheckFriList->fetch(PDO::FETCH_ASSOC);
            if($result){
                $delstmt = $this->db->prepare("DELETE FROM friends WHERE rskey = ?");
                $delstmt->execute([$result['rskey']]);
            }else{
                exit;
            }

        
            exit;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // MAKE FRIENDS
    public function make_friends($my_id, $sender_id,$date){
        
        try{
            $acceptFriRequest = "UPDATE friend_request SET req_state=1 WHERE sender = :sender_id AND receiver = :my_id";
            $friaccept_stmt = $this->db->prepare($acceptFriRequest);
            $friaccept_stmt->bindValue(':my_id',$my_id, PDO::PARAM_INT);
            $friaccept_stmt->bindValue(':sender_id', $sender_id, PDO::PARAM_INT);
            $friaccept_stmt->execute();
            if($friaccept_stmt->execute()){
                $rskey = 'QWERTYUIOPASDFGHJKLZXCVBNM123456789qwertyuiopasdfghjklzxcvbnm';
                $rskey = str_shuffle($rskey);
                $rskey = substr($rskey, 0, 20);
                $sql = "INSERT INTO `friends`(user_one, user_two,rskey,start_date) VALUES(?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$my_id, $sender_id, $rskey, $date]);
            }
            return true;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // DELETE FRIENDS 
    public function delete_friends($my_id, $user_id){
        try{
            $delete_friends = "DELETE FROM `friend_request` WHERE (sender = :my_id AND receiver = :user_id) OR (sender = :user_id AND receiver = :my_id)";
            $delete_stmt = $this->db->prepare($delete_friends);
            $delete_stmt->bindValue(':my_id',$my_id, PDO::PARAM_INT);
            $delete_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $delete_stmt->execute();
            exit;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }








    // CHECK IF REQUEST HAS ALREADY BEEN SENT
    public function request_already_sent($my_id, $user_id){
    
        try{
            $sql = "SELECT * FROM `friend_request` WHERE (sender = :my_id AND receiver = :frnd_id) OR (sender = :frnd_id AND receiver = :my_id)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':my_id',$my_id, PDO::PARAM_INT);
            $stmt->bindValue(':frnd_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
    
            if($stmt->rowCount() === 1){
                return true;
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // CHECK IF ALREADY FRIENDS
    public function is_already_friends($my_id, $user_id){
        try{
            $sql = "SELECT * FROM `friends` WHERE (user_one = :my_id AND user_two = :frnd_id) OR (user_one = :frnd_id AND user_two = :my_id)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':my_id',$my_id, PDO::PARAM_INT);
            $stmt->bindValue(':frnd_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() === 1){
                return true;
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        
    }

    //  IF I AM THE REQUEST SENDER
    public function am_i_the_req_sender($my_id, $user_id){
        try{
            $sql = "SELECT * FROM `friend_request` WHERE sender = ? AND receiver = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$my_id, $user_id]);

            if($stmt->rowCount() === 1){
                return true;
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //  IF I AM THE RECEIVER 
    public function am_i_the_req_receiver($my_id, $user_id){
        
        try{
            $sql = "SELECT * FROM `friend_request` WHERE sender = ? AND receiver = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $my_id]);

            if($stmt->rowCount() === 1){
                return true;
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    // REQUEST NOTIFICATIONS
    public function request_notification($my_id, $send_data){
        try{
            $sql = "SELECT sender, username, user_image FROM `friend_request` JOIN users ON friend_request.sender = users.id WHERE receiver = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$my_id]);
            if($send_data){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                return $stmt->rowCount();
            }

        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

    }

}
?>