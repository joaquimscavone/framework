<div class="card card-user">
  <form action="<?= route('funcionario.edit',['id'=>$id]) ?>" method="POST">
    <div class="card-header">
      <h5 class="card-title">Cadastro de Funionário</h5>
    </div>
    <div class="card-body px-4">

      <?= CSRF(); ?>
      <input type="hidden" name="id" value="<?=$id ?? ''?>">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control <?= has_error('nome', 'is-invalid') ?>"
              placeholder="Nome" value="<?= old('nome', $nome ?? '') ?>" required>
            <div class="invalid-feedback">
              <ul>
                <?php foreach (errors('nome') as $erro): ?>
                  <li><?= $erro ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4 pl-1 ">
          <div class="form-group">
            <label for="email">Endereço de E-mail</label>
            <input type="email" id="email" name="login" class="form-control  <?= has_error('email', 'is-invalid') ?>"
              placeholder="Email" value="<?= old('login', $login ?? '') ?>" required>
            <div class='invalid-feedback'>
              <ul>
                <?php foreach (errors('login') as $erro): ?>
                  <li><?= $erro ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4 pl-1">
          <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="phone" id="telefone" name="telefone"
              class="form-control  <?= has_error('telefone', 'is-invalid') ?>" id="telefone" placeholder="Telefone"
              value="<?= old('telefone', $telefone ?? ''); ?>">
            <div class='invalid-feedback'>
              <ul>
                <?php foreach (errors('telefone') as $erro): ?>
                  <li><?= $erro ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label id="CPF">CPF</label>
            <input type="text" id="CPF" maxlength="14" minlength="11" name="cpf" class="form-control  <?=has_error('cpf','is-invalid')?>" placeholder="CPF"
              value="<?= old('cpf', $cpf ?? ''); ?>" />
              <div class='invalid-feedback'>
                <ul>
                  <?php foreach (errors('cpf') as $erro): ?>
                  <li><?= $erro ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label id="RG">RG</label>
            <input type="text" id="RG" maxlength="13" name="rg" class="form-control  <?=has_error('rg','is-invalid')?>" placeholder="RG"
              value="<?= old('rg', $rg ?? ''); ?>" />
              <div class='invalid-feedback'>
                <ul>
                  <?php foreach (errors('rg') as $erro): ?>
                    <li><?= $erro ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
          </div>
        </div>
        <div class="col-md-4 pl-1">
          <div class="form-group">
            <label id="rg_expedidor">RG Orgão Expedidor</label>
            <input type="text" id="rg_expedidor" maxlength="6" minlength="6" class="form-control  <?=has_error('rg_expedidor','is-invalid')?>" name="rg_expedidor"
              placeholder="SSP/TO" value="<?= old('rg_expedidor', $rg_expedidor ?? ''); ?>">
              <div class='invalid-feedback'>
                <ul>
                  <?php foreach (errors('rg_expedidor') as $erro): ?>
                    <li><?= $erro ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" class="form-control  <?=has_error('password','is-invalid')?>" placeholder="Senha" value="">
              <div class='invalid-feedback'>
                <ul>
                  <?php foreach (errors('password') as $erro): ?>
                    <li><?= $erro ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="password">Confirmação:</label>
            <input type="password" id="password" name="confirmacao" class="form-control" placeholder="Confirme sua senha"
              value="" >
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <button type="submit" class="btn btn-primary btn-round"><i class="fa fa-floppy-o"></i> Salvar</button>
    </div>
  </form>
</div>