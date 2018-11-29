<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
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
                'full_title' => $value->name
            ];

            foreach ($value->students as $student) {
                $students[] = [
                    'name' => $student,
                    'project' => $key,
                    'mentors' => $value->mentors
                ];
            }
        }

        return $this->render('students/index.html.twig', ['students' => $students, 'projects' => $projects]);
    }

    /**
     * @Route("/student", name="students.show")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {
        $project = $request->query->get('project');
        $name = $request->query->get('name');

        return $this->render('students/show.html.twig', ['project' => $project, 'name' => $name]);
    }
}
