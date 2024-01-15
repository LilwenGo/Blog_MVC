<?php
    namespace BlogMvc\Controllers;

    use BlogMvc\Models\ArticleManager;
    use BlogMvc\Validator;
    class  ArticleController{
        private $manager;
        private $validator;
    
        public function __construct() {
            $this->manager = new ArticleManager();
            $this->validator = new Validator();
        }

        public function showInsert() {
            require VIEWS."Blog/insert.php";
        }

        public function showAllArticles() {
            $articles = $this->manager->getAll();
            require VIEWS."Blog/affiche.php";
        }

        public function create() {
            if (!isset($_SESSION["user"]["username"])) {
                header("Location: /login");
                die();
            }
            $_POST["titre"] = escape($_POST["titre"]);
            $_POST["commentaire"] = escape($_POST["commentaire"]);
            $this->validator->validate([
                "titre"=>["required", "min:2", "max:50", "alphaNumDash"],
                "commentaire"=>["required", "min:2", "alphaNumDash"]
            ]);
            $_SESSION['old'] = $_POST;
    
            if (!$this->validator->errors()) {
                $imgid = $this->manager->maxId();
                $imgname = $imgid.$_FILES["img"]["name"];
                move_uploaded_file($_FILES["img"]["tmp_name"], "../public/images/".$imgname);
                $this->manager->store($imgname);
                header("Location: /");
            } else {
                header("Location: /insert/");
            }
        }

    }
?>