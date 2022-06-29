<section class="special_cource">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section_tittle text-center">
                    <p>Mes Questions</p>
                    <h2>Mes Questions</h2>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end" class="mb-5">
            <a href="<?= $host ?>create-question" class="btn_2 text-uppercase">+ Créer une nouvelle question</a>
        </div>
        <div class="row">
            <?php foreach ($my_questions as $question) : ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_special_cource">
                        <div class="special_cource_text">
                            <a href="#" class="btn_4"><?= intval($question->level) == 1 ? 'Facile' : (intval($question->level) === 2 ? 'Moyen' : 'Difficile') ?></a>
                            <h4 class="btn_2 action-btn" style="margin-left: 8px;">&#128465;</h4>
                            <h4 onclick="location.href='<?= $host ?>update-question/<?= $question->id ?>'" class="btn_2 action-btn">&#128221;</h4>
                            <a href="#">
                                <h3><?= $question->description ?></h3>
                            </a>
                            <div class="author_info">
                                <div class="author_img" style="padding-left: 0">
                                    <div class="author_info_text">
                                        <p>Créé le:</p>
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <p><?= $question->created_at ?></p>
                                </div>
                            </div>
                            <div class="author_info">
                                <div class="author_img" style="padding-left: 0">
                                    <div class="author_info_text">
                                        <p>Nombre de choix:</p>
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <p><?= $question->choices ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .action-btn {
        padding: 5px 12px;
        border: 1px solid;
        border-radius: 2rem;
        cursor: pointer
    }
</style>