<?php

/**
 * 
 */
class ArticleManager extends Model
{
    // Function that require all the articles in DB.
    public function getArticles(){
        return $this->getAll('articles', 'Article');
    }

    public function getArticle($id){
        return $this->getOne('articles', 'Article', $id);
    }

    public function createArticle(){
        return $this->createOne('articles', 'Article');
    }
}

?>