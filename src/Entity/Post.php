<?php

namespace App\Entity;

/**
 * Class Post
 * @package App\Entity
 */
class Post
{

    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $title;
    /**
     * @var
     */
    private $created_at;
    /**
     * @var
     */
    private $content;
    /**
     * @var
     */
    private $published;
    /**
     * @var
     */
    private $user_id;
    /**
     * @var
     */
    private $img_id;
    /**
     * @var
     */
    private $numberComments;


    /**
     * @param $id
     * @return mixed|void
     */
    public function setId($id)
    {
        $id = (int)$id;
        if ($id>0) {
            $this->id = $id;
        }
    }


    /**
     * @param $title
     * @return mixed|void
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }


    /**
     * @param $created_at
     * @return mixed|void
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }


    /**
     * @param $content
     * @return mixed|void
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }


    /**
     * @param $content
     * @return mixed|void
     */
    public function setContent($content)
    {
        if (is_string($content) && strlen($content) <= 10000) {
            $this->content = $content;
        }
    }


    /**
     * @param $user_id
     * @return mixed|void
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }


    /**
     * @param $img_id
     * @return mixed|void
     */
    public function setImg_id($img_id)
    {
        $this->img_id = $img_id;
    }

    /**
     * @param $numberComments
     * @return mixed|void
     */
    public function setNumberComments($numberComments)
    {
        $this->numberComments = $numberComments;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getImg_id()
    {
        return $this->img_id;
    }

    /**
     * @return mixed
     */
    public function getNumberComments()
    {
        return $this->numberComments;
    }
}
