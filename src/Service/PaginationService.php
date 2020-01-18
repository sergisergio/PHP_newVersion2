<?php

namespace Service;

use Repository\ConfigRepository;
use Repository\BlogRepository;
use Repository\UserRepository;
use Repository\ProjectRepository;
use Repository\CategoryRepository;
use Repository\TagRepository;
use Repository\CommentRepository;

class PaginationService {

  protected $configRepository;
  protected $blogRepository;
  protected $userRepository;
  protected $projectRepository;
  protected $categoryRepository;
  protected $commentRepository;
  protected $tagRepository;

  public function __construct() {
    $this->configRepository = new ConfigRepository;
    $this->blogRepository = new BlogRepository;
    $this->userRepository = new UserRepository;
    $this->projectRepository = new ProjectRepository;
    $this->categoryRepository = new CategoryRepository;
    $this->tagRepository = new TagRepository;
    $this->commentRepository = new CommentRepository;
  }
  /**
   * PAGINATION DES ARTICLES COTE FRONT
   */
  public function paginate($currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $posts = $this->blogRepository->getPostsPagination($start, $results_per_page);
      return $posts;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES CATEGORIES COTE ADMIN
   */
  public function paginateCategory($category, $currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $posts = $this->blogRepository->getCategoryPagination($category, $start, $results_per_page);
      return $posts;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES TAGS COTE ADMIN
   */
  public function paginateTag($tag, $currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $posts = $this->blogRepository->getTagPagination($tag, $start, $results_per_page);
      return $posts;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES MEMBRES COTE ADMIN
   */
  public function paginateUser($currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $users = $this->userRepository->getUsersPagination($start, $results_per_page);
      return $users;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES PROJETS COTE ADMIN
   */
  public function paginateProject($currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $projects = $this->projectRepository->getProjectsPagination($start, $results_per_page);
      return $projects;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES CATEGORIES
   */
  public function paginateCategoryAdmin($currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $posts = $this->categoryRepository->getCategoryPagination($start, $results_per_page);
      return $posts;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES TAGS
   */
  public function paginateTagAdmin($currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $tags = $this->tagRepository->getTagPagination($start, $results_per_page);
      return $tags;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
  /**
   * PAGINER LES COMMENTAIRES
   */
  public function paginateCommentAdmin($currentPage, $number_of_pages, $results_per_page) {
    if (isset($currentPage) AND !empty($currentPage) AND ($currentPage > 0 ) AND ($currentPage <= $number_of_pages)) {
      $start = ($currentPage-1)*(int)$results_per_page;
      $comments = $this->commentRepository->getCommentPagination($start, $results_per_page);
      return $comments;
    }
    if (($currentPage > $number_of_pages) || ($currentPage < 1)) {
      header('Erreur 404', true, 404);
      include('views/404.html');
      exit();
    };
  }
}
