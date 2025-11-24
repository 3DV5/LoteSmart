<?php
require_once __DIR__ . '/app/init.php';

$route = isset($_GET['r']) ? $_GET['r'] : 'dashboard';

function render($template, $data = []) {
    extract($data);
    include __DIR__ . '/templates/layout.php';
}

// simple routing
switch ($route) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $pass = $_POST['password'] ?? '';
            if ($auth->login($email, $pass)) {
                header('Location: ?r=dashboard');
                exit;
            } else {
                $error = 'Credenciais inválidas';
            }
        }
        render('login', ['error' => $error ?? null]);
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $pass = $_POST['password'] ?? '';
            $user = new User($db);
            $id = $user->create(['name' => $name, 'email' => $email, 'password' => $pass]);
            if ($id) {
                header('Location: ?r=login');
                exit;
            } else {
                $error = 'Não foi possível criar usuário';
            }
        }
        render('register', ['error' => $error ?? null]);
        break;

    case 'logout':
        $auth->logout();
        header('Location: ?r=login');
        break;

    case 'lotes':
        $auth->requireLogin();
        $lote = new Lote($db);
        $lotes = $lote->all();
        render('lotes_list', ['lotes' => $lotes]);
        break;

    case 'lote_create':
        $auth->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'codigo' => $_POST['codigo'] ?? '',
                'descricao' => $_POST['descricao'] ?? '',
                'quantidade' => $_POST['quantidade'] ?? 0,
            ];
            $l = new Lote($db);
            // validate unique codigo
            if ($l->existsByCodigo($data['codigo'])) {
                $error = 'Código já existe';
            } else {
                $l->create($data);
                header('Location: ?r=lotes');
                exit;
            }
        }
        render('lote_form');
        break;

    case 'lote_edit':
        $auth->requireLogin();
        $id = $_GET['id'] ?? null;
        $l = new Lote($db);
        $lote = $l->findById($id);
        if (!$lote) {
            echo 'Lote não encontrado';
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'codigo' => $_POST['codigo'] ?? '',
                'descricao' => $_POST['descricao'] ?? '',
                'quantidade' => $_POST['quantidade'] ?? 0,
                'data_fabricacao' => $_POST['data_fabricacao'] ?? null,
                'data_validade' => $_POST['data_validade'] ?? null,
                'status' => $_POST['status'] ?? 'ativo',
            ];
            if ($l->existsByCodigo($data['codigo'], $id)) {
                $error = 'Código já existe em outro lote';
            } else {
                $l->update($id, $data);
                header('Location: ?r=lotes');
                exit;
            }
        }
        render('lote_form', ['lote' => $lote, 'error' => $error ?? null]);
        break;

    case 'lote_delete':
        $auth->requireLogin();
        // only admin may delete
        $auth->requireRole('admin');
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $l = new Lote($db);
            $l->delete($id);
            header('Location: ?r=lotes');
            exit;
        }
        header('Location: ?r=lotes');
        break;

    case 'dashboard':
    default:
        if (!$auth->isLogged()) {
            header('Location: ?r=login');
            exit;
        }
        $user = $auth->user();
        render('dashboard', ['user' => $user]);
        break;
}
