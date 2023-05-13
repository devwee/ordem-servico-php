<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Adicionar ordem de serviço</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="card shadow col-lg-12">
            <div class="card-body">

                <?php
                if (isset($_SESSION['msg-create-order'])) {
                    echo $_SESSION['msg-create-order'];
                    unset($_SESSION['msg-create-order']);
                }
                ?>

                <span>Preencha corretamente todos os campos.</span>
                <p class="mb-3">Os campos marcados com * são obrigatórios.</p>

                <form method="post" action="<?= $CONFIGURATION['site_url'] . 'backend/functions/orders/create_order.php'; ?>">
                    <div class="form-group">
                        <label for="inputHiddenRefOS">Ref. OS <strong>*</strong></label>
                        <input type="text" class="form-control" name="inputHiddenRefOS" id="inputHiddenRefOS" value="<?= generateNumSO(); ?>" disabled minlength="3" maxlength="128">
                        <input type="hidden" name="inputRefOS" id="inputRefOS" value="">
                    </div>
                    <h6 style="text-align: center;display: block;" class="mb-3 mt-3"><strong>Informações da ordem de serviço</strong></h6>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="inputNomeCompleto">Nome completo do cliente <strong>*</strong></label>
                            <?php if (isset($_SESSION['SAVEDnome_completo'])) : ?>
                                <input type="text" class="form-control" name="inputNomeCompleto" id="inputNomeCompleto" value="<?= $_SESSION['SAVEDnome_completo']; ?>" required minlength="3" maxlength="128">
                            <?php else : ?>
                                <input type="text" class="form-control" name="inputNomeCompleto" id="inputNomeCompleto" placeholder="ex: John Doe" required minlength="3" maxlength="128">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="inputTecnicoResponsavel">Técnico responsável <strong>*</strong></label>
                            <?php if (isset($_SESSION['SAVEDtec_responsavel'])) : ?>
                                <input type="text" class="form-control" name="inputTecnicoResponsavel" id="inputTecnicoResponsavel" value="<?= $_SESSION['SAVEDtec_responsavel']; ?>" required minlength="3" maxlength="128">
                            <?php else : ?>
                                <input type="text" class="form-control" name="inputTecnicoResponsavel" id="inputTecnicoResponsavel" placeholder="ex: John Doe" required minlength="3" maxlength="128">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="inputTelefone">WhatsApp <strong>*</strong></label>
                            <?php if (isset($_SESSION['SAVEDtelefone'])) : ?>
                                <input type="text" class="form-control" name="inputTelefone" id="inputTelefone" value="<?= $_SESSION['SAVEDtelefone']; ?>" required min="3" max="128">
                            <?php else : ?>
                                <input type="text" class="form-control" name="inputTelefone" id="inputTelefone" placeholder="55DD900000000" required min="3" max="128">
                            <?php endif; ?>
                        </div>                        
                    </div>                    
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="inputDescDefeito">Descrição do defeito</label>
                            <?php if (isset($_SESSION['SAVEDdesc_defeito'])) : ?>  
                                <textarea type="text" class="form-control" name="inputDescDefeito" id="inputDescDefeito" maxlength="2000"><?= $_SESSION['SAVEDdesc_defeito']; ?></textarea>
                            <?php else : ?>
                                <textarea type="text" class="form-control" name="inputDescDefeito" id="inputDescDefeito" maxlength="2000"></textarea>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="inputItens">Itens para troca/reparo</label>
                            <?php if (isset($_SESSION['SAVEDitens'])) : ?>  
                                <textarea type="text" class="form-control" name="inputItens" id="inputItens" maxlength="2000"><?= $_SESSION['SAVEDitens']; ?></textarea>
                            <?php else : ?>
                                <textarea type="text" class="form-control" name="inputItens" id="inputItens" maxlength="2000"></textarea>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label>Serviços:</label>
                            <?php
                                global $mysqli;
                                global $tabela_servicos;
                                $sql = "SELECT * FROM $tabela_servicos ORDER BY nome ASC";
                                $result = $mysqli->query($sql);
                                $i = 0; // contador de colunas

                                if($result->num_rows > 0){
                                    echo '<div class="form-row">';
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="form-group col-lg-3">';
                                            echo '<div class="form-check">';
                                                echo '<input class="form-check-input" type="checkbox" name="servicos[]" id="servicos-'.$row['id'].'" value="'.$row['valor'].'" onclick="updateServicosSelecionados()">';
                                                echo '<label class="form-check-label" for="servicos-'.$row['id'].'">'.$row['nome'].' - R$ '.$row['valor'].'</label>';
                                            echo '</div>';
                                        echo '</div>';
                                        $i++;
                                        if ($i == 4) {                                
                                            echo '</div><div class="form-row">';
                                            $i = 0;
                                        }
                                    }
                                    echo '</div>';
                                } else {
                                    echo '
                                    <div class="w-full text-center p-t-25">
                                        <div class="alert alert-warning" role="alert">
                                            <strong>ATENÇÃO:</strong> Nenhum registro foi encontrado.<br>
                                            <span>Cadastre serviços feito por você clicando <a href="'.$CONFIGURATION['site_url'].'panel/princings/list-princings">aqui</a>.
                                        </div>
                                    </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                    <div id="servicos-container">
                        <div class="form-row">
                            <textarea id="servicos-selecionados" name="servicos-selecionados" style="display:none; white-space: pre-wrap;"></textarea>
                        </div>
                    </div>

                    <h6 style="text-align: center;display: block;" class="mb-3 mt-3"><strong>Informações de pagamentos</strong></h6>
                    <div class="form-row">
                        <div class="form-group col-lg-3">
                            <label for="inputValorTotal">Valor total</label>   
                            <?php if (isset($_SESSION['SAVEDvalor_total'])) : ?>
                                <input type="text" class="form-control" name="inputHiddenValorTotal" id="inputHiddenValorTotal" value="<?=$_SESSION['SAVEDvalor_total'];?>" disabled maxlength="128">
                                <input type="hidden" name="inputValorTotal" id="inputValorTotal" value="">
                            <?php else: ?>
                                <input type="text" class="form-control" name="inputHiddenValorTotal" id="inputHiddenValorTotal" placeholder="R$ 0,00" disabled maxlength="128">
                                <input type="hidden" name="inputValorTotal" id="inputValorTotal" value="">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-lg-3">
                            <?php if (isset($_SESSION['SAVEDdesconto'])) : ?>
                                <label for="inputDesconto">Desconto <small>(em %)</small></label>                            
                                <input type="text" class="form-control" name="inputDesconto" id="inputDesconto" value="<?=$_SESSION['SAVEDvalor_total'];?>" maxlength="128">                            
                            <?php else: ?>
                                <label for="inputDesconto">Desconto <small>(em %)</small></label>                            
                                <input type="text" class="form-control" name="inputDesconto" id="inputDesconto" placeholder="0%" maxlength="128">                            
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="inputFormaPagamento">Forma de pagamento <strong>*</strong></label>
                            <select id="inputFormaPagamento" class="form-control" name="optionsFormaPagamento">
                                <?php if (isset($_SESSION['SAVEDFormaPagamento']) && $_SESSION['SAVEDFormaPagamento'] == 0) : ?>
                                    <option value="0" selected>Pagamento pendente</option>
                                <?php else : ?>
                                    <option value="0">Pagamento pendente</option>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['SAVEDFormaPagamento']) && $_SESSION['SAVEDFormaPagamento'] == 1) : ?>
                                    <option value="1" selected>Pagamento dinheiro</option>
                                <?php else : ?>
                                    <option value="1">Pagamento dinheiro</option>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['SAVEDFormaPagamento']) && $_SESSION['SAVEDFormaPagamento'] == 2) : ?>
                                    <option value="2" selected>Pagamento cartão débito</option>
                                <?php else : ?>
                                    <option value="2">Pagamento cartão débito</option>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['SAVEDFormaPagamento']) && $_SESSION['SAVEDFormaPagamento'] == 3) : ?>
                                    <option value="3" selected>Pagamento cartão crédito</option>
                                <?php else : ?>
                                    <option value="3">Pagamento cartão crédito</option>
                                <?php endif; ?>
                            </select>
                        </div> 
                        <div class="form-group col-lg-3">
                            <label for="inputParcelas">Parcelado? <small>(parcelas)</small></label>
                            <?php if (isset($_SESSION['SAVEDparcelas'])) : ?>
                                <input type="text" class="form-control" name="inputParcelas" id="inputParcelas" value="<?= $_SESSION['SAVEDparcelas']; ?>" min="3" max="128">
                            <?php else : ?>
                                <input type="text" class="form-control" name="inputParcelas" id="inputParcelas" placeholder="0" min="3" max="128">
                            <?php endif; ?>
                        </div>
                    </div>
                    <h6 style="text-align: center;display: block;" class="mb-3 mt-3"><strong>Informações de conclusão</strong></h6>  
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="inputDataConclusao">Data de conclusão</label>
                            <?php if (isset($_SESSION['SAVEDdata_conclusao'])) : ?>
                                <input type="text" class="form-control" name="inputDataConclusao" id="inputDataConclusao" value="<?= $_SESSION['SAVEDdata_conclusao']; ?>" min="3" max="10">
                            <?php else : ?>
                                <input type="text" class="form-control" name="inputDataConclusao" id="inputDataConclusao" placeholder="00/00/0000" min="3" max="10">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputStatus">Status</label>
                            <select id="inputStatus" class="form-control" name="optionsStatus">
                                <?php if (isset($_SESSION['SAVEDstatus']) && $_SESSION['SAVEDstatus'] == 0) : ?>
                                    <option value="0" selected>Em aberto</option>
                                <?php else : ?>
                                    <option value="0">Em aberto</option>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['SAVEDstatus']) && $_SESSION['SAVEDstatus'] == 1) : ?>
                                    <option value="1" selected>Finalizado</option>
                                <?php else : ?>
                                    <option value="1">Finalizado</option>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['SAVEDstatus']) && $_SESSION['SAVEDstatus'] == 2) : ?>
                                    <option value="2" selected>Cancelado</option>
                                <?php else : ?>
                                    <option value="2">Cancelado</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <h6 style="text-align: center;display: block;" class="mb-3 mt-3"><strong>Outras informações</strong></h6>

                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="inputObservacoes">Observações</label>
                            <?php if (isset($_SESSION['SAVEDobservacoes'])) : ?>  
                                <textarea type="text" class="form-control" name="inputObservacoes" id="inputObservacoes" maxlength="2000"><?= $_SESSION['SAVEDobservacoes']; ?></textarea>
                            <?php else : ?>
                                <textarea type="text" class="form-control" name="inputObservacoes" id="inputObservacoes" maxlength="2000"></textarea>
                            <?php endif; ?>
                        </div>
                    </div>

                    <a class="btn btn-primary" href="<?= $CONFIGURATION['site_url'] . 'panel/orders/list-orders'; ?>" style="text-decoration:none;color:#fff">
                        &larr;Voltar
                    </a>
                    <button type="submit" name="create_os" class="btn btn-success">Registrar ordem de serviço</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('inputRefOS').value         = document.getElementsByName('inputHiddenRefOS')[0].value;
        document.getElementById('inputValorTotal').value    = document.getElementsByName('inputHiddenValorTotal')[0].value;
        
        var checkboxes = document.querySelectorAll('input[name="servicos[]"]');
        var valorTotal = 0;
        
        function calcularValorTotal() {        
        var desconto = document.getElementById("inputDesconto").value;
        desconto = parseFloat(desconto.replace(',', '.'));
        desconto = isNaN(desconto) ? 0 : desconto; 

        var valores = Array.from(checkboxes)
            .filter(function(checkbox) { return checkbox.checked })
            .map(function(checkbox) { return Number(checkbox.value) });
        valorTotal = valores.reduce((a, b) => a + b, 0);
        valorTotal = valorTotal - (valorTotal * (desconto / 100));
                
        document.getElementById("inputHiddenValorTotal").value = "R$ " + valorTotal.toFixed(2);
        document.getElementById("inputValorTotal").value = valorTotal.toFixed(2);
        }
        
        document.getElementById("inputDesconto").addEventListener("keyup", function() {
        calcularValorTotal();
        });
        
        checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {     
            calcularValorTotal();
        });
        });

        function updateServicosSelecionados() {
            var servicosSelecionados = [];
            var checkboxes = document.querySelectorAll('input[name="servicos[]"]:checked');
            for (var i = 0; i < checkboxes.length; i++) {
                var checkbox = checkboxes[i];
                var label = checkbox.nextElementSibling;
                var nome = label.innerHTML.split(' - R$ ')[0];
                var valor = label.innerHTML.split(' - R$ ')[1];
                servicosSelecionados.push(nome + ' - R$ ' + valor + '; ');
            }
            document.getElementById('servicos-selecionados').innerHTML = servicosSelecionados.join('\n');
        }

    </script>

    <!-- Content Row -->

</div>