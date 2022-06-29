<section class="special_cource">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section_tittle text-center">
                    <p>Questionnaires</p>
                    <h2>Questionnaires</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($my_quizzes as $quizz) : ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_special_cource">
                        <div class="special_cource_text">
                            <a href="#" class="btn_4"><?= intval($quizz->level) == 1 ? 'Facile' : (intval($quizz->level) === 2 ? 'Moyen' : 'Difficile') ?></a>
                            <h4 style="padding: 5px 12px; border: 1px solid; border-radius: 2rem"><?= $quizz->score ?></h4>
                            <a href="<?= $host ?>quizz/<?= $quizz->quizz_id ?>">
                                <h3><?= $quizz->title ?></h3>
                            </a>
                            <div class="author_info">
                                <div class="author_img" style="padding-left: 0">
                                    <div class="author_info_text">
                                        <p>Créé par:</p>
                                        <h5><a href="#"><?= $quizz->quizzer ?></a></h5>
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <!-- <p>Note obtenue</p> -->
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