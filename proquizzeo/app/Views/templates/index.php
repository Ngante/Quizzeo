<!doctype html>
<html lang="fr">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quizzeo</title>

    <link rel="stylesheet" href="<?= $assets ?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= $assets ?>css/global.bootstrap.css" />
    <link rel="stylesheet" href="<?= $assets ?>custom/custom.css" />

    <script src="<?= $assets ?>js/jquery-1.12.1.min.js"></script>

</head>

<body>

    <?php if ($vue !== 'common/home') : ?>
        <header class="main_menu home_menu" style="position: relative; margin-bottom: 30px;">
        <?php else : ?>
            <?= '<header class="main_menu home_menu">' ?>
        <?php endif; ?>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="<?= $host ?>">
                            <h3>Quizzeo</h3>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">
                            <ul class="navbar-nav align-items-center">

                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= $host ?>questions">Quizz</a>
                                </li>

                                <?php if ($authObj->logged()) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= $host ?>dashboard">Mon parcours</a>
                                    </li>


                                    <?php if ($user->role === "QUIZZER") : ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= $host ?>my-quizzes">Mes Quizzs</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= $host ?>my-questions">Mes Questions</a>
                                        </li>
                                    <?php endif; ?>


                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= $host ?>logout">Déconnexion (<?= $user->pseudo ?>)</a>
                                    </li>
                                <?php else : ?>

                                    <li class="d-none d-lg-block">
                                        <a class="btn_1" href="<?= $host ?>login">Se connecter</a>
                                    </li>
                                <?php endif ?>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        </header>

        <?= $contentPage ?>

        <footer style="margin: 100px">

        </footer>

        <script src="<?= $assets ?>js/jquery.magnific-popup.js"></script>
        <script src="<?= $assets ?>js/custom.js"></script>
        <script src="<?= $assets ?>custom.js"></script>
</body>

</html>