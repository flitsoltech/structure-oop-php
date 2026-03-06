<?php

require_once __DIR__ . '/../models/Student.php';

class StudentController
{

    private Student $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    public function index(): void
    {
        $keyword  = $_GET['search'] ?? '';
        $students = $keyword
            ? $this->studentModel->search($keyword)
            : $this->studentModel->getAll();

        require_once __DIR__ . '/../views/students/index.php';
    }

    public function create(): void
    {
        require_once __DIR__ . '/../views/students/create.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data   = $this->sanitize($_POST);
            $errors = $this->validate($data);

            if (!empty($errors)) {
                require_once __DIR__ . '/../views/students/create.php';
                return;
            }

            if ($this->studentModel->create($data)) {
                $this->redirect('?action=index&msg=created');
            } else {
                $errors[] = "Some Thing Went Wrong.";
                require_once __DIR__ . '/../views/students/create.php';
            }
        }
    }
 
    public function edit(): void
    {
        $id      = (int)($_GET['id'] ?? 0);
        $student = $this->studentModel->getById($id);

        if (!$student) {
            $this->redirect('?action=index&msg=notfound');
        }

        require_once __DIR__ . '/../views/students/edit.php';
    }
 
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = (int)($_POST['id'] ?? 0);
            $data   = $this->sanitize($_POST);
            $errors = $this->validate($data);

            if (!empty($errors)) {
                $student       = $data;
                $student['id'] = $id;
                require_once __DIR__ . '/../views/students/edit.php';
                return;
            }

            if ($this->studentModel->update($id, $data)) {
                $this->redirect('?action=index&msg=updated');
            }
        }
    } 
    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($this->studentModel->delete($id)) {
            $this->redirect('?action=index&msg=deleted');
        }
    } 

    private function sanitize(array $data): array
    {
        return [
            'name'   => htmlspecialchars(trim($data['name']   ?? '')),
            'email'  => htmlspecialchars(trim($data['email']  ?? '')),
            'course' => htmlspecialchars(trim($data['course'] ?? '')),
            'age'    => (int)($data['age'] ?? 0),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['name']))                                    $errors[] = "Name IS Mandatory.";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))     $errors[] = "Vali Email Please.";
        if (empty($data['course']))                                  $errors[] = "Course Required.";
        if ($data['age'] < 5 || $data['age'] > 100)                 $errors[] = "Age 5-100 Around Between.";
        return $errors;
    }

    private function redirect(string $url): void
    {
        header("Location: index.php{$url}");
        exit;
    }
}
