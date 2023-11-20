<?php 
    session_start();

    class Book{
        public $title;
        public $author;
        public $year;

        function __construct($title, $author, $year){
            $this->title = $title;
            $this->author = $author;
            $this->year = $year;
        }
    }
    
    class Library{
        public $books = [];

        public function addBook(Book $book){
            array_push($this->books, $book);

            echo "book was added";
        }

        public function removeBook($bookTitle){
            $index = array_search($bookTitle, array_column($this->books, 'title'));

            if ($index !== false) {
                array_splice($this->books, $index, 1);

                echo "Book with title '" . $bookTitle . "' was successfully deleted";
              
            }
            else{
                echo "Book with title '" . $bookTitle . "' not found";
            }
           
        }

        public function getBookList(){
            return $this->books;
        }

    }

    if(!isset($_SESSION['lib'])){
        $_SESSION['lib'] = new Library();
    }
   
    

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        echo json_encode($_SESSION['lib']->getBookList());
        
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $requestBody = file_get_contents('php://input');

        $x = json_decode($requestBody, true);


        $_SESSION['lib']->addBook(new Book($x['title'], $x['author'], $x['year']));
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        // $_SESSION['lib']->removeBook($_POST['title']);
        $requestBody = file_get_contents('php://input');

        $x = json_decode($requestBody, true);

        $_SESSION['lib']->removeBook($x['title']);

    }
?>