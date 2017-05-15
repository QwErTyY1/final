<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.05.2017
 * Time: 15:17
 */
class HomeModel
{

    public $child_cat_cid;

    public $user_name;
    public $user_email;
    public $user_date;
    public $user_id_soc;


    public function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }


    public function addUser($user_name, $user_email,$user_id_soc)
    {
        $user_date = strtotime(date("Y-m-d"));

        $sql = "INSERT INTO users (user_name, user_email, user_date, user_id_so ) VALUES (:user_name, :user_email, :user_date, :user_id_so)";

        $query = $this->db->prepare($sql);
        $parameters = array(':user_name' => $user_name, ':user_email' => $user_email, ':user_date' => $user_date, ':user_id_so' => $user_id_soc);

        $query->execute($parameters);
    }

    public function updateUser($user_id_soc)
    {
//        $user_date = strtotime(date("Y-m-d"));

        $sql = "UPDATE users SET  user_date = :user_date WHERE user_id_so = :user_id_soc ";

        $query = $this->db->prepare($sql);
        $parameters = array(':user_date' => date(time()) , ':user_id_soc' => $user_id_soc);

        $query->execute($parameters);
    }


    public function getUser($user_id_soc)
    {
        $sql = "SELECT * FROM users WHERE user_id_so = :user_id_soc LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id_soc' => $user_id_soc);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }


    public function getMessagesByUserId($user_id = "")
    {
        $sql  = "SELECT users.user_name, users.user_email, comment.comment_message, comment.comment_created ";
        $sql .= "FROM users ";
        $sql .= "LEFT JOIN comment ";
        $sql .= "ON users.id = comment.comment_user_id ";
        $sql .= "WHERE users.id = $user_id ";
        $sql .= "ORDER BY comment.comment_created DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();



    }

    public function addComment($user_id, $comment_message = "", $comment_parent_id = 0)
    {

        $comment_created = date(time());

        $sql = "INSERT INTO comment (comment_user_id, comment_message, comment_parent_id, comment_created) VALUE (:comment_user_id, :comment_message, :comment_parent_id, :comment_created)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':comment_user_id'   => $user_id,
            ':comment_message'   => $comment_message,
            ':comment_parent_id' => $comment_parent_id,
            ':comment_created'   => $comment_created,
        );
        $query->execute($parameters);

        return true;

    }


    public function getUserIdBySocMail($email)
    {
        $sql = "SELECT users.id FROM users WHERE user_email = :user_email";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_email' => $email);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getArrayTree($parent_id = 0)
    {
        $date = [];
        $i = 0;

        $sql  = "SELECT comment.comment_id, comment.comment_parent_id, comment.comment_message, user_name ";
        $sql .= "FROM comment ";
        $sql .= "LEFT JOIN users ";
        $sql .= "ON users.id = comment.comment_user_id ";
        $sql .= "WHERE comment.comment_parent_id = $parent_id";

        $query = $this->db->prepare($sql);
        $query->execute();

        $arrayTree = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($arrayTree as $item){

            $date[$i]['comment_id'] = (int) $item['comment_id'];
//            $date[$i]['comment_parent_id'] = ($item['comment_parent_id'] == 0)? null : (int)$item['comment_parent_id'] ;
            $date[$i]['comment_parent_id'] =  (int)$item['comment_parent_id'] ;
            $date[$i]['comment_message'] = (string) $item['comment_message'];
            $date[$i]['user_name'] = (string) $item['user_name'];

            $i++;
        }
        return $date;

    }

    public function countPagination()
    {
        $sql  = "SELECT comment.comment_id, comment.comment_created, comment.comment_parent_id, comment.comment_message, users.user_name ";
        $sql .= "FROM comment ";
        $sql .= "LEFT JOIN users ";
        $sql .= "ON users.id = comment.comment_user_id ";

        $sql .= "ORDER BY comment.comment_parent_id DESC";

        $query = $this->db->prepare($sql);
        $query->execute();

        return$query->fetchAll(PDO::FETCH_ASSOC);
    }




    public function setCatList($comment_parent_id = 0)
    {

        $sql  = "SELECT comment.comment_id, comment.comment_created, comment.comment_parent_id, comment.comment_message, users.user_name ";
        $sql .= "FROM comment ";
        $sql .= "LEFT JOIN users ";
        $sql .= "ON users.id = comment.comment_user_id ";

        $sql .= "WHERE comment.comment_parent_id = $comment_parent_id ";
        $sql .= "ORDER BY comment.comment_created DESC";

        $query = $this->db->prepare($sql);
        $query->execute();

        $row = $query->fetchAll(PDO::FETCH_ASSOC);

        $page = ! empty( $_POST['page'] ) ? (int) $_POST['page'] : 1;



        $total = count($row); //total items in array

        $limit = 1; //per page
        $totalPages = ceil( $total/ $limit );


        $page = max($page, 1);
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $limit;

        if( $offset < 0 ) $offset = 0;

         return $yourDataArray = array_slice( $row, $offset, $limit );


    }



    public function cat_list($comment_parent_id = 0)
    {


        $row = $this->setCatList( $comment_parent_id);



        ob_start();
            echo "<div class='container'>";
            echo "<div class='row col-md-5'>";
            echo "<ul class='Goin table table-responsive'>";
            foreach ($row as $item) {

                echo "<ol style='height: auto; background: #F9F9F9; border: 1px solid #E1E1E8; margin: 10px 0; padding: 10px; '>";

                echo "<span class='glyphicon glyphicon-user'></span>";
                echo "<div class='small'>date: " .date("Y-m-d G:i", $item['comment_created']). "<div>";
                echo "<h6><strong>".$item['user_name']."</strong></h6>";

                echo "  ";

                echo $item['comment_message'];
                echo "<br />";
                echo "<button class='btn_hidden_id btn btn-default' id='$item[comment_id]'>Answer</button>";

                echo "</ol>";
                $this->cat_list($item['comment_id']);

            }
            echo "</ul>";
            echo "</div>";
            echo "</div>";
             return $content = ob_get_contents();
        }

    public function deleteYourComment($comm_id)
    {
        $sql = "DELETE FROM comment WHERE comment_id = :comment_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':comment_id' => $comm_id);

        $query->execute($parameters);
    }

    public function yourListCount($user_id)
    {

        $sql  = "SELECT * ";
        $sql .= "FROM comment ";
        $sql .= "WHERE comment_user_id =:comment_user_id";

        $options = array(":comment_user_id" => $user_id);

        $query = $this->db->prepare($sql);
        $query->execute($options);

        return $query->rowCount();
    }


    public function yourListPagination($page, $user_id)
    {
        $count = null;

        if (!empty($user_id) && $user_id !== 0) {
            if ($count !== false && $count > 0) {
                $count = $this->yourListCount($user_id);
            }

        }

        $paginator = new Pagination($page, 5,$count);

        if ($paginator instanceof Pagination){
            $start = $paginator->getStart();
            $num = $paginator->getNum();
        }

        $sql = "SELECT * FROM comment LIMIT $start, $num";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);


    }



     public function del($name){


        unset($_SESSION[$name]);

        return $this;
    }


    public function destroy(){
        $_SESSION = array();
        session_destroy();
        return $this;
    }





}