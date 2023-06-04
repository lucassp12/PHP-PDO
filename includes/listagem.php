<?php
$resultados = '';
foreach ($vagas as $vaga) {
    $resultados .= '<tr>
                  <td>' . $vaga->id . '</td>
                  <td>' . $vaga->titulo . '</td>
                  <td>' . $vaga->descricao . '</td>
                  <td>' . ($vaga->ativo === 's' ? 'Ativo' : 'Inativo') . '</td>
                  <td>' . date('d/m/Y à\s H:i:s', strtotime($vaga->data)) . '</td>
                  <td>
                  <a href="editar.php?id=' . $vaga->id . '"><button type="button" class="btn btn-primary">Editar</button></a>
                  <a href="excluir.php?id=' . $vaga->id . '"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal">Excluir</button></a>
                  </td>
                  </tr>';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                   <td colspan="6" class="text-center">
                                                   Nenhuma vaga encontrada
                                                   </td>
                                                  </tr>';

//GETS
unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);
//Páginação
$paginacao = '';
$paginas = $obPagination->getPages();
foreach ($paginas as $pagina) {
    //$class = $pagina['pagina'] == $pagina['atual'] ? 'btn-primary' : 'btn-light';
    //$paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '">
    //            <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>';

    $class = $pagina['pagina'] == $pagina['atual'] ? 'active' : '';
    $paginacao .= '<li class="page-item ' . $class . '"><a class="page-link" href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">' . $pagina['pagina'] . '</a></li>';
}

$paginaAnterior = $pagina['atual'] == 1
    ? '<li class="page-item disabled">
         <a class="page-link" href="?pagina=' . ($pagina['atual'] > 1 ? $pagina['atual'] - 1 : 1) . '&' . $gets . '">Anterior</a>
      </li>'
    : '<li class="page-item">
         <a class="page-link" href="?pagina=' . ($pagina['atual'] > 1 ? $pagina['atual'] - 1 : 1) . '&' . $gets . '">Anterior</a>
       </li>';

$paginaProxima = $pagina['atual'] == $pagina['total']
    ? '<li class="page-item disabled">
         <a class="page-link" href="?pagina=' . ($pagina['atual'] > 1 ? $pagina['atual'] - 1 : 1) . '&' . $gets . '">Anterior</a>
       </li>'
    : '<li class="page-item">
         <a class="page-link" href="?pagina=' . ($pagina['atual'] < $pagina['total'] ? $pagina['atual'] + 1 : $pagina['total']) . '&' . $gets . '">Próxima</a>
       </li>';
?>

<main>
    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova vaga</button>
        </a>
    </section>

    <section>
        <form method="get">
            <div class="row my-4">
                <div class="col">
                    <label>Buscar por título</label>
                    <input type="text" name="busca" class="form-control"
                        value="<?= $busca = isset($busca) ? $busca : '' ?>">
                </div>
                <div class="col">
                    <label>Status</label>
                    <select name="filtroStatus" class="form-control">
                        <option value="">Ativa/Inativo</option>
                        <option value="s" <?= $filtroStatus == 's' ? 'selected' : '' ?>>Ativa</option>
                        <option value="n" <?= $filtroStatus == 'n' ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>

            </div>
        </form>
    </section>

    <section>
        <table class="table bg-light mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo $resultados;
                ?>
            </tbody>
        </table>
    </section>
    <section>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?= $paginaAnterior ?>
                <?= $paginacao ?>
                <?= $paginaProxima ?>
            </ul>
        </nav>
    </section>
</main>