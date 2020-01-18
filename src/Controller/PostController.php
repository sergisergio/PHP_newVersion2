<?php

namespace App\Controller;

use Core\View;
use Core\Request;
use Core\Response;
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
class PostController extends Controller
{
    protected $blogRepository;
    protected $paginationService;
    protected $configRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $linkRepository;
    protected $commentRepository;
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
        $this->view = new View;
    }

    /*
     * AFFICHER UN ARTICLE EN PARTICULIER
     *
     * - met en place un token CSRF pour l'ajout d'un commentaire
     * - récupération de l'article avec son identifiant
     * - récupération des catégories, tags, populaires, liens, sous-liens et tags par article
     * - récupération des commentaires liés à l'article
     */
    public function __invoke(Request $request) {

        $token = bin2hex(openssl_random_pseudo_bytes(6));
        $_SESSION['add_comment_token'] = $token;
        $_SESSION['update_comment_token'] = $token;
        $_SESSION['delete_comment_token'] = $token;

        // if (!isset($_SESSION['add_comment_token']) || ($_SESSION['add_comment_token'] == NULL)) {
        //    $_SESSION['add_comment_token'] = bin2hex(openssl_random_pseudo_bytes(6));
        // }

        //if (isset($_GET['id']) && $post = $this->blogModel->getPostById($_GET['id'])) {
        //var_dump($request->attributes->get('id'));die();
        $id = $request->attributes->get('id');
        //var_dump($id);die();
        if (isset($id) && $post = $this->blogRepository->getPostById($id) ) {
            if ($post['published'] || $this->isAdmin()) {
                $post['content'] = htmlspecialchars_decode($post['content'], ENT_HTML5);
                $categories = $this->categoryRepository->getAllCategories();
                $tags = $this->tagRepository->getAllTags();
                $populars = $this->blogRepository->getMostSeens();
                $links = $this->linkRepository->getAllLinks();
                $sublinks = $this->linkRepository->getAllSublinks();
                $id = '';
                $tags_per_post = $this->blogRepository->getTagsPerPost($id);
                if ($this->isLogged()) {
                    $comments = $this->commentRepository->getVerifiedCommentsByPostId($post['id']);
                } else {
                    $comments = null;
                }
                // echo $this->twig->render('front/blog/_partials/post/index.html.twig', [
                //     'post'              => $post,
                //     'comments'          => $comments,
                //     'message'           => $this->msg,
                //     'maxLength'         => $this->configModel->getConfig()['characters'],
                //     'categories'        => $categories,
                //     'tags'              => $tags,
                //     'populars'          => $populars,
                //     //'subcomments'       => $subcomments,
                //     'links'             => $links,
                //     'sublinks'          => $sublinks,
                //     'tags_per_post'     => $tags_per_post,
                //     'add_comment_token' => $token,
                //     'update_comment_token' => $token,
                //     'delete_comment_token' => $token,
                // ]);

                return new Response(200, [], $this->view->render('index', 'front/blog/_partials/post', [
                    'post'              => $post,
                    'comments'          => $comments,
                    'message'           => $this->msg,
                    'maxLength'         => $this->configRepository->getConfig()['characters'],
                    'categories'        => $categories,
                    'tags'              => $tags,
                    'populars'          => $populars,
                    //'subcomments'       => $subcomments,
                    'links'             => $links,
                    'sublinks'          => $sublinks,
                    'tags_per_post'     => $tags_per_post,
                    'add_comment_token' => $token,
                    'update_comment_token' => $token,
                    'delete_comment_token' => $token,
                ]));
            } else {
                $this->redirect404();
            }
        } else {
            $this->redirect404();
        }
    }

}
