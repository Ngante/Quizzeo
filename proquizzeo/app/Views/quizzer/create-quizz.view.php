<section class="special_cource">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section_tittle text-center">
                    <p>Nouveau Questionnaire</p>
                    <h2>Nouveau Questionnaire</h2>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end" class="mb-5">
            <button id="save-question" type="button" class="btn_2 text-uppercase">Enregistrer le questionnaire</button>
        </div>

        <form class="form" method="POST" id="create-form">
            <input type="hidden" name="questions_data" id="questions_data" />
            <input type="hidden" name="create-quizz" />

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title">Titre du questionnaire</label>
                    <input required multiple type="text" name="title" id="title" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="level">Difficulté</label>
                        <select required name="level" id="level" class="form-control">
                            <option value="">Sélectionnez la difficulté</option>
                            <option selected value="1">Facile</option>
                            <option value="2">Moyen</option>
                            <option value="3">Difficile</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" id="submit-form" class="d-none"></button>
        </form>

        <h3>Gestion des questions</h3>
        <h6>Veuillez sélectionner les questions que vous souhaitez ajouter au Quizz</h6>
        <br />

        <div class="row">
            <?php $i = 0;
            foreach ($questions as $question) : ?>
                <div class="col-sm-6 col-lg-4">

                    <div class="single_special_cource">


                        <div class="special_cource_text">



                            <a href="#" class="btn_4"><?= intval($question->level) == 1 ? 'Facile' : (intval($question->level) === 2 ? 'Moyen' : 'Difficile') ?></a>

                            <div class="confirm-switch" style="position: absolute; top: 40px; right: 40px">
                                <input data-id="<?= $question->id ?>" type="checkbox" id="confirm-switch-<?= $i ?>" class="choice-answer-<?= $i ?>" />
                                <label for="confirm-switch-<?= $i ?>"></label>
                            </div>

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
            <?php $i++;
            endforeach; ?>
        </div>


    </div>
</section>

<style>
    .country {
        width: 40% !important;
    }

    .percentage {
        width: 19% !important;
    }

    .visit {
        width: 26% !important;
    }
</style>

<style>
    .action-btn {
        padding: 5px 12px;
        border: 1px solid;
        border-radius: 2rem;
        cursor: pointer
    }
</style>

<script>
    let QuestionsList = JSON.parse('<?= json_encode($questions) ?>');

    const refresh_actions = () => {
        for (let index = 0; index < QuestionsList.length; index++) {
            const element = QuestionsList[index];

            $(".choice-answer-" + index).change((e) => {

                const value = e.target.checked;
                const current_id = e.target.getAttribute('data-id');

                QuestionsList[index].checked = value;

                refresh_questions();
            })
        }
    }

    const refresh_questions = () => {
        for (let index = 0; index < QuestionsList.length; index++) {
            const element = QuestionsList[index];

            if (element.checked) {
                $(".choice-answer-" + index).attr("checked", "");
            } else {
                $(".choice-answer-" + index).removeAttr("checked");
            }

        }

        $("#questions_data").val(JSON.stringify(QuestionsList.filter(q => q.checked).map(q => q.id)));

        refresh_actions();
    }


    refresh_questions();

    $('#save-question').click((e) => {
        e.preventDefault();
        if (QuestionsList.findIndex(c => c.checked) === -1) {
            alert("Il doit y avoir au moins une question !");
            return;
        }

        $("#submit-form").click();
    })
</script>