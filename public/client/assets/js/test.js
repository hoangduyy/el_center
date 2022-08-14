$(document).ready(function () {
    DethiController.init();
});

var DethiController = {
    init: function () {
        console.log('js is working');
        DethiController.submitAnswer();
    },

    submitAnswer: function () {
        $('input[type=radio]').change(function () {
            var question_id = $(this).data('question-id');
            var user_da = $(this).val();
            var csrf = $('meta[name="csrf-token"]').attr('content');
            var url = $('input[name="answer"]').val();

            let data = {
                'question_id': question_id,
                'user_da': user_da,
            };

            $.ajax({
                type: 'POST',
                url: url,
                headers: {'X-CSRF-TOKEN': csrf},
                data: data,
                cache: false,
                success: function (response) {
                    switch (response.status) {
                        case 201:
                            location.reload();
                        case 200:
                            console.log('Submit answer successfully ... ');
                            break;
                        default:
                            console.log('Submit answer error ... ')
                    }
                },
                error: function (e) {
                    console.log('Submit answer error ... ')
                }
            });
        })
    }
};


