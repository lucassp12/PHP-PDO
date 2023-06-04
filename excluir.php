<?php
require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Vaga;

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

$obVaga = Vaga::getVaga($_GET['id']);

//Validar a vaga

if (!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}

if (isset($_POST['excluir'])) {
    $obVaga->id = $_GET['id'];
    $obVaga->excluir();
    header('location: index.php?status=sucess');
    exit;
}

if (isset($_POST['cancelar'])) {
    header('location: index.php?status=sucess');
    exit;
}

$vagas = VAGA::getVagas();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/confirmar-exclusao.php';
include __DIR__ . '/includes/footer.php';