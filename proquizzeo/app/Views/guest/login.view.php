<section class="banner_part">
    <form class="auth-modal" method="POST">
        <h3 class="text-center mb-3">Connexion à Quizzeo</h3>

        <?php if ($login_errors) : ?>
            <div class="text-danger mb-3" style="color: #df4838"><?= $login_errors ?></div>
        <?php endif; ?>

        <div class="form-group">
            <input required class="form-control" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Adresse email'" placeholder="Adresse email" />
        </div>
        <div class="form-group">
            <input required class="form-control" name="password" id="password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Mot de passe'" placeholder="Mot de passe" />
        </div>

        <button class="btn_2 container mb-4" type="submit" name="login">Connexion</button>

        <div class="text-right">Pas encore de compte ? <a href="<?= $host ?>register">Inscrivez-vous !</a> </div>
    </form>
</section>


<style>
    .banner_part {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-modal {
        z-index: 9;
        width: 500px;
        height: 340px;
        border-radius: 2rem;
        background-color: rgba(200, 200, 200, .9);
        padding: 20px;
    }

    input.form-control {
        height: 50px;
        border-radius: 20px;
    }
</style>