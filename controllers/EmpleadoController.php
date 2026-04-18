<?php
require_once dirname(__DIR__) . '/models/Empleado.php';

class EmpleadoController {
    private Empleado $model;

    public function __construct() {
        $this->model = new Empleado();
    }

    public function handleRequest(): void {
        $action = $_GET['action'] ?? 'index';

        match($action) {
            'index'   => $this->index(),
            'create'  => $this->create(),
            'store'   => $this->store(),
            'edit'    => $this->edit(),
            'update'  => $this->update(),
            'delete'  => $this->delete(),
            'search'  => $this->search(),
            default   => $this->index(),
        };
    }

    // Listar todos
    private function index(): void {
        $empleados = $this->model->getAll();
        require __DIR__ . '/../views/empleados/index.php';
    }

    // Formulario crear
    private function create(): void {
        require __DIR__ . '/../views/empleados/create.php';
    }

    // Guardar nuevo
    private function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirect('index'); return; }

        $this->model->nombre   = trim($_POST['nombre']   ?? '');
        $this->model->apellido = trim($_POST['apellido'] ?? '');
        $this->model->dni      = trim($_POST['dni']      ?? '');

        $errors = $this->validate();
        if (!empty($errors)) {
            $empleado = null;
            require __DIR__ . '/../views/empleados/create.php';
            return;
        }

        if ($this->model->create()) {
            $this->redirect('index', 'success', 'Empleado registrado correctamente.');
        } else {
            $this->redirect('index', 'error', 'No se pudo registrar el empleado.');
        }
    }

    // Formulario editar
    private function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $empleado = $this->model->getById($id);
        if (!$empleado) { $this->redirect('index', 'error', 'Empleado no encontrado.'); return; }
        require __DIR__ . '/../views/empleados/edit.php';
    }

    // Actualizar
    private function update(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirect('index'); return; }

        $this->model->id       = (int)($_POST['id']      ?? 0);
        $this->model->nombre   = trim($_POST['nombre']   ?? '');
        $this->model->apellido = trim($_POST['apellido'] ?? '');
        $this->model->dni      = trim($_POST['dni']      ?? '');

        $errors = $this->validate();
        if (!empty($errors)) {
            $empleado = $this->model->getById($this->model->id);
            require __DIR__ . '/../views/empleados/edit.php';
            return;
        }

        if ($this->model->update()) {
            $this->redirect('index', 'success', 'Empleado actualizado correctamente.');
        } else {
            $this->redirect('index', 'error', 'No se pudo actualizar el empleado.');
        }
    }

    // Eliminar
    private function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            $this->redirect('index', 'success', 'Empleado eliminado correctamente.');
        } else {
            $this->redirect('index', 'error', 'No se pudo eliminar el empleado.');
        }
    }

    // Buscar
    private function search(): void {
        $query     = trim($_GET['q'] ?? '');
        $empleados = $query ? $this->model->search($query) : $this->model->getAll();
        require __DIR__ . '/../views/empleados/index.php';
    }

    // Validación básica
    private function validate(): array {
        $errors = [];
        if (empty($this->model->nombre))   $errors[] = 'El nombre es obligatorio.';
        if (empty($this->model->apellido)) $errors[] = 'El apellido es obligatorio.';
        if (empty($this->model->dni))      $errors[] = 'El DNI es obligatorio.';
        elseif (!ctype_digit($this->model->dni)) $errors[] = 'El DNI solo debe contener números.';
        return $errors;
    }

    private function redirect(string $action, string $msg_type = '', string $msg = ''): void {
        $url = "index.php?action={$action}";
        if ($msg_type) $url .= "&msg_type={$msg_type}&msg=" . urlencode($msg);
        header("Location: {$url}");
        exit;
    }
}
