<?php $template->title = "Mesa " . $atendimento->mesa; ?>
<div class="row pb-5">
    <div class="col pb-5">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?= component('atendimentos.card-list-pedidos', ['atendimento' => $atendimento]); ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="card text-white bg-info mb-3 w-100">
                                        <div class="card-body">
                                            <div class="">
                                                Total:
                                            </div>
                                            <h2 class="text-center" id="total_atendimento">
                                                <?= money($atendimento->getSaldo()); ?>
                                            </h2>
                                        </div>
                                        <div class="card-footer text-dark">
                                            Cod. Atendimento <?= $atendimento->id ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="text-center col-12">
                                            <a href="<?= route('home') ?>" class="btn btn-warning w-100">
                                                <i class="fa fa-arrow-left mr-2"></i> <span>Voltar [&#x232b;]</span>
                                            </a>
                                        </div>
                                        <div class="text-center col-12">
                                            <a href="<?= route('home') ?>" class="btn btn-info w-100">
                                                <i class="fa fa-user-o mr-2"></i> <span>Add Cliente [C] </span>
                                            </a>
                                        </div>
                                        <div class="text-center col-12">
                                            <a href="#" class="btn btn-success w-100" data-toggle="modal"
                                                data-target="#registrar-pagamento">
                                                <i class="fa fa-money mr-2"></i>
                                                <span>Registrar Pagamento [p]</span>
                                            </a>
                                        </div>
                                        <div class="text-center col-12">
                                            <a href="#" class="btn btn-primary w-100" data-toggle="modal"
                                                data-target="#finalizar-atendimento">
                                                <i class="fa fa-handshake-o mr-2"></i>
                                                Finalizar Atendimento [F]
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 order-first order-md-last">
                                    <?= component('card-pedido', ['atendimento' => $atendimento]); ?>

                                 <div class="row py-3">
                                        <div class="col">
                                            <?= component('atendimentos.card-pagamentos', ['atendimento' => $atendimento]); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=component('atendimentos.modal-registrar-pagamento',['atendimento'=>$atendimento]);?>
<?=component('atendimentos.modal-finalizar-atendimento',['atendimento'=>$atendimento]);?>