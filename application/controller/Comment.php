<?php
ini_set('display_errors','Off');
class Comment extends Controller
{






    public function index()
    {
        session_start();


        $countPage = $this->model->countPagination();
        $limit = 2;

        $total = count($countPage);

        $totalPages = ceil( $total/ $limit );


        $user = new stdClass();
        $user->login = false;

        $fb = new FacebookH('438429649857985', '1bb3f60cfe9ce5ba3b97a5e0350dcd65','v2.9');

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://home.dev/final/home/callback', $permissions);

        if (isset($_SESSION['user']['name'])) {

            $user->login = true;
        }



        //get YOUR MESSAGES //




        $usered_id      = null ;
        $your_messages  = null;
                if ($this->model->getUserIdBySocMail($_SESSION['user']['email'])) {
                    $usered_id = $this->model->getUserIdBySocMail($_SESSION['user']['email']);
                    if ($this->model->getUserIdBySocMail($_SESSION['user']['email'])){

                        $_SESSION['usered_id'] = $usered_id->id;

                        $your_comment_message = $this->model->yourListPagination(1, $usered_id);

                        $total_your_pages = intval(($this->model->yourListCount($usered_id->id) - 1) /5)+1;

                    } else {

                    }


                } else {


                }



        $messages = new stdClass();
        $messages->commment_message = '';
        $messages->act = '';
        $messages->class = '';
        $messages->date = '';

        $active = "comment";


        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST["comment_message"])){

                if (!empty($_POST["comment_message"]) || $_POST["comment_message"] > 0) {

                    $email =(string)$_SESSION["user"]['email'];
                    $user_id_soc = $_SESSION['user']['id'];

                    $comment_message = $this->test_input($_POST["comment_message"]);
                    $comment_parent_id = $this->test_input($_POST['idUses']);


                    $user->user_id = $this->model->getUserIdBySocMail($email);

                    if ($this->model->addComment($user->user_id->id, $comment_message, $comment_parent_id) === true){

                        $messages->commment_message = "Your message was successfully added!";
                        $messages->class = "alert-success";
                        $messages->act = 'Success!';

                        $data = $this->model->getUser($user_id_soc);
                        $messages->date = date("Y-m-d h:i:sa", $data->user_date) ;

                    }

                } else {
                    $messages->commment_message = "The message can not be empty";
                    $messages->class =  "alert-danger";
                    $messages->act = "Error!";
                }
                    //ajax view comment ALL
                   $this->model->cat_list();
            }
        } else {
            require APP . 'view/_templates/header.php';
            require APP . 'view/comments_page/main_page.php';
            require APP . 'view/_templates/footer.php';
        }
    }

        public function ajaxPagination()
        {
            session_start();

            if (isset($_POST['page']) && is_numeric($_POST['page'])){

                $page = ($_POST['page'] == 0) ?1: (int) $_POST['page'];
                $_SESSION['cur_page'] = $page;

                $this->model->cat_list();
            }
        }


        public function your_list($id)
        {
           $total = count($this->model->yourList($id));

        }


        public function getAjYour()
        {
            session_start();

            $itemDel = $_POST['itemDel'];
            $usered_id = $_SESSION['usered_id'];

            $page = ($_SESSION['page']==null)?1:$_SESSION['page'];

            ob_start();
            {
                $this->model->deleteYourComment($itemDel);


                $your_comment_message = $this->model->yourListPagination($page, $usered_id);
                require_once APP . "/view/block/block_your_comment_messages.php";

                $content = ob_get_contents();
            }
            $content;
        }


        public function ajaxYourPagination()
        {
            session_start();

            $usered_id = $_SESSION['usered_id'];
            $page = $_POST['pages'];

            $_SESSION['page'] = ($_SESSION['page']==null)?1:$_SESSION['page'];

            $itemDel = $_POST['itemDel'];


            ob_start();
            {
                $this->model->deleteYourComment($itemDel);
                $your_comment_message = $this->model->yourListPagination($page, $usered_id);
                $pagess = $_POST['pages'];
                require_once APP . "/view/block/block_your_comment_messages.php";

                $content = ob_get_contents();
            }
            $content;

        }





}