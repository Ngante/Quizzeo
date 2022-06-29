$(document).ready(function () {
  const refresh_question = () => {
    const current_question = Questions[current_index];
    current_choices = current_question.choices;

    $("#question-title").html(current_question.title);

    const answers = current_question.answers;
    $("#question-answers").html("");

    for (let i = 0; i < answers.length; i++) {
      const element = answers[i];

      const a_class = current_choices.includes(element)
        ? "btn_1 container"
        : "btn_2 container";

      const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

      const html_text = `
          <div class="question-choice">
              <a href="#" class="${a_class} single-choice" data-value="${element}">
                  <b>${alphabet.charAt(i)}.</b>
                  ${element}
              </a>
          </div>
      `;

      $("#question-answers").append(html_text);
    }

    $(".single-choice").click(function (e) {
      e.preventDefault();
      const answer = $(this).data("value");

      if (!current_choices.includes(answer)) {
        current_choices.push(answer);
      } else {
        current_choices.splice(current_choices.indexOf(answer), 1);
      }

      refresh_question();
    });

    refresh_numbers();
    refresh_buttons();
  };

  const refresh_numbers = () => {
    $(".numbers-list").html("");

    $("#question-number-title").html(`${current_index + 1}`);
    $("#question-number").html(`${current_index + 1}`);
    $("#question-total").html(`${Questions.length}`);

    for (let i = 1; i <= Questions.length; i++) {
      const a_class = i <= current_index + 1 ? "btn_1" : "btn_2";
      const elem = `
              <a href="#" class="${a_class} number-case">${i}</a>
          `;

      $(".numbers-list").append(elem);
    }
  };

  const refresh_buttons = () => {
    if (current_index === 0) {
      $("#btn-previous").hide();
    } else {
      $("#btn-previous").show();
    }

    if (current_index === Questions.length - 1) {
      $("#btn-next").hide();
    } else {
      $("#btn-next").show();
    }

    if (current_choices.length === 0) {
      $("#btn-submit").hide();
    } else {
      $("#btn-submit").show();
    }

    // submit button toggle
    if (current_index === Questions.length - 1) {
      $("#btn-submit").show();
    } else {
      $("#btn-submit").hide();
    }
  };

  $("#btn-next").click(function (e) {
    e.preventDefault();

    if (current_choices.length === 0) {
      alert("Veuillez choisir une réponse");
      return;
    }

    $("#page-content").hide();

    Questions[current_index].choices = current_choices;
    current_choices = [];

    current_index++;

    if (current_index >= Questions.length) {
      current_index = 0;
    }

    refresh_question();

    setTimeout(() => {
      $("#page-content").show();
    }, 10);
  });

  $("#btn-previous").click(function (e) {
    e.preventDefault();

    $("#page-content").hide();

    current_index--;
    current_choices = [];
    if (current_index < 0) {
      current_index = Questions.length - 1;
    }

    refresh_question();

    setTimeout(() => {
      $("#page-content").show();
    }, 10);
  });

  refresh_question();
});
