<?php


class Home extends Controller
{




    public function index()
    {



        $active = "home";

        session_start();
        $user = new stdClass();

        $fb = new FacebookH('438429649857985', '1bb3f60cfe9ce5ba3b97a5e0350dcd65','v2.9');

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://home.dev/final/home/callback', $permissions);
        if (isset($_SESSION['user'])){

            $user->email = $_SESSION['user']['email'];
            $user->id = $_SESSION['user']['id'];

            if (isset($_SESSION['user']['name'])) {

                $user->name = $_SESSION['user']['name'];
            }




            require APP . 'view/_templates/header.php';
            require APP . 'view/home/home.php';
            require APP . 'view/_templates/footer.php';

        } else {

            require APP . 'view/_templates/header.php';
            require APP . 'view/home/home.php';
            require APP . 'view/_templates/footer.php';

        }


    }


    public function callback()
    {
        $error = new stdClass();
        $error->message = '';

        $success = new stdClass();
        $success->message = '';

        session_start();
        $fb = new FacebookH('438429649857985', '1bb3f60cfe9ce5ba3b97a5e0350dcd65','v2.9');

        $helper = $fb->getRedirectLoginHelper();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $access_token = $helper->getAccessToken();
            $response = $fb->get('/me?fields=id,name,email', $access_token);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            $error->message = 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $error->message = 'Facebook SDK returned an error: ' . $e->getMessage();

        }

        $user = $response->getGraphUser();
//        var_dump($this->model->getUser($user->getId()));
        if ($getUs = $this->model->getUser($user->getId())){
            $this->model->updateUser($user->getId());
             $success->message = "Thank you for being with us";
        } else {
            $this->model->addUser($user->getName(),$user->getEmail(),$user->getId());
            $success->message = 'User ADD';
        }




        $_SESSION['message'] = $success->message;
       // add header auth
        $_SESSION['user'] = $user;





        header('Location: http://home.dev/final/comment/');
        exit;


    }

    public function logOut()
    {
        session_start();

        $this->model->destroy();

        header('Location: http://home.dev/final/');
        exit;

    }


}