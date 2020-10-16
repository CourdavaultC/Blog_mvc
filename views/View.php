<?php

/**
 * 
 */
class View
{
    private $_file;

    private $_t;

    function __construct($action)
    {
        $this->_file = 'views/view'.$action.'.php';
    }

    // Function to generate the view
    public function generate($data){
        // définir le contenu à envoyer
        $content = $this->generateFile($this->_file, $data);

        // template
        $view = $this->generateFile('views/template.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }

    // Create and generate the view of all articles
    public function generatePost($data){
        // Select the content to send it
        $content = $this->generateFile($this->_file, $data);

        // Template
        $view = $this->generateFile('views/templateSingle.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }

    // Generate the view of the form that create articles.
    public function generateForm(){
        $content = $this->generateFileSimple($this->_file);

        // Template
        $view = $this->generateFile('views/templateForm.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }

    // Artcile view generate
    private function generateFile($file, $data){
        if (file_exists($file)) {
            extract($data);

            // Start the temporisation
            ob_start();

            require $file;

            // Stop the temporisation
            return ob_get_clean();
        }else {
            throw new \Exception("Fichier ".$file." introuvable", 1);
        }
    }
    
    private function generateFileSimple($file){
        if (file_exists($file)) {
            require $file;
        }
        else {
            throw new \Exception("Fichier ".$file." introuvable", 1);
        }
    }
}
?>