<?php
require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Vaga;
use \App\Db\Pagination;

//BUSCA
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//Filtro Status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
$filtroStatus = in_array($filtroStatus, ['s', 'n']) ? $filtroStatus : '';

//Condições SQl
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%' . str_replace(' ', '%', $busca) . '%"' : null,
    strlen($filtroStatus) ? 'ativo = "' . $filtroStatus . '"' : null
];

$condicoes = array_filter($condicoes);

//Cláusa WHERE
$where = implode(' AND ', $condicoes);

$quantidadeVagas = Vaga::getQuantidadeVagas($where);

//Paginação
$obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 5);
$limit = $obPagination->getLimit();


$vagas = VAGA::getVagas($where, null, $limit);

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/listagem.php';
include __DIR__ . '/includes/footer.php';