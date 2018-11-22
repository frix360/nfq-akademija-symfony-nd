<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="students.index")
     */
    public function index()
    {
        $dataJson = file_get_contents(__DIR__ . '/../../public/students.json', FILE_USE_INCLUDE_PATH);

        $data = json_decode($dataJson);
        $students = [];
        $projects = [];

        foreach ($data as $key => $value) {
            $projects[] = [
                'short_title' => $key,
                'full_title' => $value->name,
                'github_link' => 'github.com/nfqakademija/' . $key,
                'web_link' => $key . '.projektai.nfqakademija.lt/ ',
                'ssh' => 'ssh.' .  $key . '@deploy.nfqakademija.lt -p 2222'
            ];

            foreach ($value->students as $student) {
                $students[] = [
                    'name' => $student,
                    'project' => $key,
                    'mentors' => $value->mentors
                ];
            }
        }

        return $this->render('students/index.html.twig', compact('students', 'projects'));
    }

    /**
     * @Route("/student", name="students.show")
     */
    public function show() {

        return $this->render('students/show.html.twig');
    }
}
