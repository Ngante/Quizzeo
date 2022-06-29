<section class="feature_part" id="page-content">
    <div class="container">
        <div class="row" id="game-container">
            <div class="col-md-8">

                <div class="shadow-sm rounded question-details">
                    <p><b>Question <span id="question-number-title"></span></b></p><br />
                    <p id="question-title"></p>
                </div>

                <h4 class="text-center proposal-list-title">PROPOSITIONS</h4>

                <div class="choices-container" id="question-answers"></div>

                <div class="actions-container row text-center container">

                    <div class="col-md-6">
                        <a href="#" class="btn_2" id="btn-previous">
                            <span>Retour</span>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="#" class="btn_2" id="btn-next">
                            <span>Suivant</span>
                        </a>
                        <button type="submit" class="btn_2" id="btn-submit">
                            <span>Soumettre mes reponses</span>
                        </button>
                    </div>

                </div>

            </div>
            <div class=" col-md-4 numbers-container shadow-sm rounded">
                <div class="">
                    <p>Question <span id="question-number"></span> / <span id="question-total"></span></p>
                </div>
                <div class="numbers-list">
                </div>
            </div>
        </div>

        <div id="gameover-container">

            <div id="title-score" class="text-center">
                <h1>18 / 20</h1>

                <p class="mb-5">Est votre score pour cette partie. Lisez la correction ci-dessous pour en apprendre davantages</p>
            </div>

            <div id="correction-container"></div>

            <a class="btn_2" href="<?= $host ?>quizz">Retour aux quizzs</a>
        </div>
    </div>
</section>

<script>
    $("#gameover-container").hide();

    let current_index = 0;
    let current_choices = [];
    let current_score = 0;
    let best_score = 0;

    const host = "<?= $host ?>";

    const Questions = [
        <?php foreach ($quizz->questions as $question) : ?> {
                title: "<?= $question->question->description ?>",
                answers: [...<?= json_encode($question->choices) ?>].map(q => q.description),
                correct: [...<?= json_encode($question->choices) ?>].filter(a => a.answer === '1').map(q => q.description),
                choices: [],
            },
        <?php endforeach; ?>
    ];

    const show_correction = () => {
        $("#game-container").hide();
        $("#correction-container").html("");

        const template = (question, index) => {
            let responses = "";
            for (let i = 0; i < question.answers.length; i++) {
                const element = question.answers[i];

                let classe = "line-through";
                if (question.correct.includes(element)) {
                    classe = "correct";
                } else {
                    if (question.choices.includes(element)) {
                        classe = "line-through bad";
                    }
                }

                responses += `<p class="${classe}">${element}</p>`;
            }
            return `
      <div class="question-row mb-4">
        <h3><b>Q${index + 1}.</b> ${question.title}</h3>
        <div class="answers-container">${responses}</div>
      </div>
    `;
        };

        Questions.forEach((question, index) => {
            $("#correction-container").append(template(question, index));
        });

        // Affichage du score
        $("#title-score>h1").html(current_score + " / " + best_score);

        $("#gameover-container").show();
    };


    $("#btn-submit").click(function(e) {
        const data = new FormData();
        data.append("quizz_id", "<?= $quizz->id ?>");
        data.append("quizz_datas", JSON.stringify(Questions));
        data.append("user_id", "<?= $user->id ?>");

        fetch(host + 'ajax/submitQuizz', {
            method: "POST",
            body: data
        }).then((res) => res.json()).then((res) => {
            current_score = res.score;
            best_score = res.total;
            show_correction();
        }).catch(console.error);

    });
</script>

<style>
    .answers-container {
        margin-left: 50px;
    }

    .answers-container .correct {
        color: green
    }

    .line-through {
        text-decoration: line-through;
    }

    .bad {
        color: red !important;
    }
</style>