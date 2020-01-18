<?php

namespace App\Controller;

use Core\View;
use Core\Request;
use Core\Response;
use Repository\CategoryRepository;
use Repository\ProjectRepository;
use Repository\SkillRepository;
use Repository\DescriptionRepository;
use Service\SecurityService;

/**
 * CLASSE GERANT LA PAGE D'ACCUEIL
 */
class HomeController extends Controller
{
    protected $skillRepository;
    protected $categoryRepository;
    protected $projectRepository;
    protected $descriptionRepository;
    protected $securityService;
    /**
     * @var View
     */
    protected $view;

    public function __construct() {
        parent::__construct();
        $this->projectRepository = new ProjectRepository;
        $this->categoryRepository = new CategoryRepository;
        $this->skillRepository = new SkillRepository;
        $this->descriptionRepository = new DescriptionRepository;
        $this->securityService = new SecurityService;
        $this->view = new View;
    }
    /*
     * AFFICHE LA PAGE D'ACCUEIL
     */
    public function __invoke(Request $request) {
        $projects = $this->projectRepository->getAllPublishedProjects();
        $categories = $this->categoryRepository->getAllCategories();
        $skills = $this->skillRepository->getAllSkills();
        $skills2 = $this->skillRepository->getAllSkills2();
        $description = $this->descriptionRepository->getDescription();
        $token = bin2hex(openssl_random_pseudo_bytes(6));
        $_SESSION['update_about_token'] = $token;
        $_SESSION['update_skill_token'] = $token;
        $_SESSION['add_skill_token'] = $token;
        $_SESSION['delete_skill_token'] = $token;
        $_SESSION['add_skill2_token'] = $token;
        $_SESSION['delete_skill2_token'] = $token;
        $_SESSION['update_skill2_token'] = $token;
        $_SESSION['update_subtitle'] = $token;

        // echo $this->twig->render('front/home/index.html.twig', [
        //     'projects'              => $projects,
        //     'categories'            => $categories,
        //     'skills'                => $skills,
        //     'skills2'               => $skills2,
        //     'description'           => $description,
        //     'message'               => $this->msg,
        //     'update_about_token'    => $token,
        //     'update_skill_token'    => $token,
        //     'add_skill_token'       => $token,
        //     'delete_skill_token'    => $token,
        //     'add_skill2_token'      => $token,
        //     'delete_skill2_token'   => $token,
        //     'update_skill2_token'   => $token,
        //     'update_subtitle'       => $token,
        // ]);

        return new Response(200, [], $this->view->render('index', 'front/home', [
                'projects'              => $projects,
                'categories'            => $categories,
                'skills'                => $skills,
                'skills2'               => $skills2,
                'description'           => $description,
                'message'               => $this->msg,
                'update_about_token'    => $token,
                'update_skill_token'    => $token,
                'add_skill_token'       => $token,
                'delete_skill_token'    => $token,
                'add_skill2_token'      => $token,
                'delete_skill2_token'   => $token,
                'update_skill2_token'   => $token,
                'update_subtitle'       => $token,
        ]));
    }
}
