<?php

namespace App\Controller;

use Repository\BlogRepository;
//use Service\PaginationService;
use Repository\ConfigRepository;
use Repository\TagRepository;
use Repository\CategoryRepository;
use Repository\LinkRepository;

/**
 * class SearchController
 *
 * Cette classe gère le formulaire de recherche du blog
 */
class BlogSearchController extends Controller
{
    protected $blogRepository;
    //protected $paginationService;
    protected $configRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $linkRepository;

    public function __construct() {
        parent::__construct();
        $this->blogRepository = new BlogRepository;
        //$this->paginationService = new PaginationService;
        $this->configRepository = new ConfigRepository;
        $this->categoryRepository = new CategoryRepository;
        $this->tagRepository = new TagRepository;
        $this->linkRepository = new LinkRepository;
    }
    /**
     * METHODE QUI TRAITE LA RECHERCHE ET RETOURNE LA PAGE ADEQUATE
     */
    public function index($search)
    {
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        if (isset($search) && $search != null) {
            $results_per_page = $this->configRepository->getConfig()['ppp'];
            $populars = $this->blogRepository->getMostSeens();
            $categories = $this->categoryRepository->getAllCategories();
            $tags = $this->tagRepository->getAllTags();
            $url = $this->getUrl();
            $posts = $this->blogRepository->searchRequest($search);
            $number = $this->blogRepository->countSearchRequest($search);
            $number = (int)$number;
            $number_of_pages = ceil($number/$results_per_page);
            $tags_per_post = $this->blogRepository->getTagsPerPost($id);
            if ($number > 0)
            {
              if (isset($_GET['page']) AND !empty($_GET['page']) AND ($_GET['page'] > 0 ) AND ($_GET['page'] <= $number_of_pages)) {
                  $_GET['page'] = intval($_GET['page']);
                  $currentPage = $_GET['page'];
              } else {
                  $currentPage = 1;
              }
              if ($currentPage > $number_of_pages) {
                  $this->redirect404();
              }
              $start = ($currentPage-1)*(int)$results_per_page;
              $posts = $this->blogRepository->getSearchPagination($search, $start, $results_per_page);
            } else {
              $posts = [];
            }
            echo $this->twig->render('front/blog/_partials/search/index.html.twig', [
                'posts'         => $posts,
                'number'        => $number,
                'numberOfPages' => $number_of_pages,
                'categories'    => $categories,
                'tags'          => $tags,
                'url'           => $url,
                'populars'      => $populars,
                'q'             => $search,
                'tags_per_post' => $tags_per_post,
                '__DIR__'       => '?c=blogSearch&q='.$search,
            ]);
        }
    }
}
