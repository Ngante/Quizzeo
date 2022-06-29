<section class="special_cource">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section_tittle text-center">
                    <p>Mes Questionnaires</p>
                    <h2>Mes Questionnaires</h2>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end" class="mb-5">
            <a href="<?= $host ?>create-quizz" class="btn_2 text-uppercase">+ Créer un nouveau questionnnaire</a>
        </div>
        <div class="row">
            <?php foreach ($my_quizzes as $quizz) : ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_special_cource">
                        <div class="special_cource_text">
                            <a href="#" class="btn_4"><?= intval($quizz->level) == 1 ? 'Facile' : (intval($quizz->level) === 2 ? 'Moyen' : 'Difficile') ?></a>
                            <h4 class="btn_2" style="
                             padding: 5px 12px; margin-left: 8px; border: 1px solid; border-radius: 2rem;
                             cursor: pointer
                             ">&#128465;</h4>
                            <h4 class="btn_2" style="
                             padding: 5px 12px; border: 1px solid; border-radius: 2rem;
                             cursor: pointer
                             ">&#128221;</h4>
                            <a href="<?= $host ?>quizz/<?= $quizz->id ?>">
                                <h3><?= $quizz->title ?></h3>
                            </a>
                            <div class="author_info">
                                <div class="author_img" style="padding-left: 0">
                                    <div class="author_info_text">
                                        <p>Créé le:</p>
                                        <!-- <h5><a href="#"><?= $quizz->quizzer ?></a></h5> -->
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <p><?= $quizz->created_at ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>