<?php

namespace App\Controller;

use Core\View;
use Core\Request;
use Core\Response;
use App\Entity\Post;
use Repository\BlogRepository;
use Service\PaginationService;
use Repository\ConfigRepository;
use Repository\TagRepository;
use Repository\CategoryRepository;
use Repository\LinkRepository;
use Repository\CommentRepository;

/**
 * CLASSE GERANT LE BLOG
 */
class BlogController extends Controller
{
    protected $blogRepository;
    protected $paginationService;
    protected $configRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $linkRepository;
    protected $commentRepository;
    protected $post;
    /**
     * @var View
     */
    protected $view;

    public function __construct() {
        parent::__construct();
        $this->blogRepository = new BlogRepository;
        $this->paginationService = new PaginationService;
        $this->configRepository = new ConfigRepository;
        $this->categoryRepository = new CategoryRepository;
        $this->tagRepository = new TagRepository;
        $this->linkRepository = new LinkRepository;
        $this->commentRepository = new CommentRepository;
        $this->post = new Post;
        $this->view = new View;
    }
    /**
     * AFFICHER LA PAGE PRINCIPALE
     *
     * - récupère le type d'affichage désiré
     * - récupération des articles et pagination
     * - récupération des 3 articles les plus commentés
     * - récupération des catégories
     * - récupération des tags
     * - récupération des liens
     * - récupération des sous-liens
     * - récupération des tags par article
     */
    public function __invoke(Request $request) {

        // if ($request->isMethod('POST')) {
        //     if (isset($_GET['v']) && !empty($_GET['v'])) {
        //         echo '<pre>';
        //         var_dump($request->getQuery('v'));
        //         echo '</pre>';
        //         die();
        //     }
        // }
        var_dump($this->post->getId());die();
        $view = $request->attributes->get('v');
        $currentPage = $request->attributes->get('p');
        //$view = $_GET['v'];
        //$currentPage = intval($_GET['page']);
        $results_per_page = $this->configRepository->getConfig()['ppp'];
        $number_of_posts = $this->blogRepository->getNumberOfPosts();
        $number_of_pages = ceil($number_of_posts/$results_per_page);
        $url = $this->getUrl();
        $posts = $this->paginationService->paginate($currentPage, $number_of_pages, $results_per_page);
        $populars = $this->blogRepository->getMostSeens();
        $categories = $this->categoryRepository->getAllCategories();
        $tags = $this->tagRepository->getAllTags();
        $links = $this->linkRepository->getAllLinks();
        $sublinks = $this->linkRepository->getAllSublinks();
        $id = "";
        $tags_per_post = $this->blogRepository->getTagsPerPost($id);

        $data = [
            'posts'         => $posts,
            'numberOfPages' => $number_of_pages,
            'number'        => $number_of_posts,
            'categories'    => $categories,
            'tags'          => $tags,
            'url'           => $url,
            'populars'      => $populars,
            'links'         => $links,
            'sublinks'      => $sublinks,
            'tags_per_post' => $tags_per_post,
            ];


        if ($view == "1") {
            $data['__DIR__'] = '/blog/1/';
            return new Response(200, [], $this->view->render('index', 'front/blog', $data));
        } elseif ($view == "2") {
            $data['__DIR__'] = '?c=blog&v=view2';
            return new Response(200, [], $this->view->render('index2', 'front/blog', $data));
        } elseif ($view == '3') {
            $data['__DIR__'] = '?c=blog&v=view3';
            return new Response(200, [], $this->view->render('index3', 'front/blog', $data));
        } else {
            //$this->redirect404();
            echo '404';die();
        }
    }
}
