<section class="banner_part">
    <form class="auth-modal" method="POST">
        <h3 class="text-center mb-3">Inscription à Quizzeo</h3>

        <?php if ($register_errors) : ?>
            <div class="text-danger mb-3" style="color: #df4838"><?= $register_errors ?></div>
        <?php endif; ?>
        <div class="form-group">
            <select required class="form-control" name="role" id="role">
                <option value="USER">Utilisateur</option>
                <option value="QUIZZER">Quizzer</option>
            </select>
        </div>
        <div class="form-group">
            <input required class="form-control" name="pseudo" id="pseudo" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez votre nom'" placeholder="Entrez votre nom" />
        </div>
        <div class="form-group">
            <input required class="form-control" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez votre adresse email'" placeholder="Entrez votre adresse email" />
        </div>
        <div class="form-group">
            <input required class="form-control" name="password" id="password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez votre mot de passe'" placeholder="Entrez votre mot de passe" />
        </div>

        <button class="btn_2 container mb-3" type="submit" name="register">S'inscrire</button>

        <div class="text-right">Vous avez déjà un compte ? <a href="<?= $host ?>login">Connectez-vous !</a> </div>
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
        height: 440px;
        border-radius: 2rem;
        background-color: rgba(200, 200, 200, .9);
        padding: 20px;
    }

    input.form-control {
        height: 50px;
        border-radius: 20px;
    }
</style>