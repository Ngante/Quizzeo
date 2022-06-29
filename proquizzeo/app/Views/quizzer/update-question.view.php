<section class="special_cource">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section_tittle text-center">
                    <p>Modifier la Question</p>
                    <h2>Modifier la Question</h2>
                </div>
            </div>
        </div>
        <!-- <div style="display: flex; justify-content: flex-end" class="mb-5">
            <a href="<?= $host ?>create-question" class="btn_2 text-uppercase">+ Créer une nouvelle question</a>
        </div> -->
        <form class="form" method="POST" id="create-form">
            <input type="hidden" name="choices_data" id="choices_data" />
            <input type="hidden" name="create-question" />

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="description">Votre Question</label>
                    <input required type="text" name="description" id="description" class="form-control" value="<?= $question->description ?>" />
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="level">Difficulté</label>
                        <select name="level" id="level" class="form-control">
                            <option value="">Sélectionnez la difficulté</option>
                            <option value="1">Facile</option>
                            <option value="2">Moyen</option>
                            <option value="3">Difficile</option>
                            <option class="d-none" selected value="<?= $question->level ?>"><?= intval($question->level) == 1 ? 'Facile' : (intval($question->level) === 2 ? 'Moyen' : 'Difficile') ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" id="submit-form" class="d-none"></button>
        </form>

        <h3>Gestion des choix</h3>

        <div class="progress-table-wrap mb-4">
            <div class="progress-table">
                <div class="table-head">
                    <div class="serial">#</div>
                    <div class="country">Choix</div>
                    <div class="visit">Correct ?</div>
                    <div class="percentage">Actions</div>
                </div>

                <div id="choices-table"></div>

                <button id="add-choice" type="button" class="btn_2 text-uppercase" style="margin: 10px; padding: 10px; font-size: 12px">+ Ajouter un choix</button>
            </div>
        </div>

        <button id="save-question" type="button" class="btn_2 text-uppercase" style="display: flex; margin: auto">Enregistrer la question</button>

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

<script>
    let Datas = JSON.parse('<?= json_encode($question->choices) ?>');
    const Choices = Datas.map(c => ({
        ...c,
        answer: c.answer === '1'
    }))

    const get_choice_template = (choice, index) => {
        return `
        <div class="table-row">
            <div class="serial">0${index+1}</div>
            <input data-index="${index}" class="country choice-title form-control" style='background: white; margin-right: 30px' value="${choice.description}" />
            <div class="visit">
                <div class="confirm-switch">
                    <input data-index="${index}" type="checkbox" id="confirm-switch-${index}" ${choice.answer ? 'checked' : ''} class="choice-answer-${index}" />
                    <label for="confirm-switch-${index}"></label>
                </div>
            </div>
            <div class="percentage">
                <h4 data-index="${index}" class="btn_2 delete-choice" style="
                padding: 5px 12px; margin-left: 8px; border: 1px solid; border-radius: 2rem;
                cursor: pointer
                ">&#128465;</h4>
            </div>
        </div>
        `
    }

    const refresh_actions = () => {
        $('.delete-choice').click((e) => {
            e.preventDefault();

            Choices.splice($(this).data('index'), 1);
            refresh_choices();
        })

        $('.choice-title').on("change", (e) => {
            Choices[e.target.getAttribute('data-index')].description = e.target.value;
            refresh_choices();
        })

        for (let index = 0; index < Choices.length; index++) {
            const element = Choices[index];
            $(".choice-answer-" + index).change((e) => {
                console.log(e.target);
                const value = e.target.checked;
                Choices[e.target.getAttribute('data-index')].answer = value ? 1 : 0;
                refresh_choices();
            })
        }
    }

    const refresh_choices = () => {
        $("#choices-table").html("");
        for (let i = 0; i < Choices.length; i++) {
            const element = Choices[i];
            $("#choices-table").append(get_choice_template(element, i))
        }

        $("#choices_data").val(JSON.stringify(Choices))

        refresh_actions();
    }

    $("#add-choice").click((e) => {
        e.preventDefault();

        Choices.push({
            description: "",
            answer: false
        });

        refresh_choices();
    });

    refresh_choices();

    $('#save-question').click((e) => {
        e.preventDefault();
        if (Choices.findIndex(c => c.answer) === -1) {
            alert("Il doit y avoir au moins un choix valide !");
            return;
        }

        if (Choices.findIndex(c => !c.description.trim()) !== -1) {
            alert("Veuillez remplir tous les champs ou supprimer ceux qui sont inutiles !");
            return;
        }

        $("#submit-form").click();
    })
</script>