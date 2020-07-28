$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("body").on("click", '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $(".open_filter").on("click", function(event) {
        event.preventDefault();

        box = $(".form_advanced");
        button = $(this);

        if (box.css("display") !== "none") {
            button.text("Filtro Avançado ↓");
        } else {
            button.text("✗ Fechar");
        }

        box.slideToggle();
    });

    //filtros da pagina home ==================================================

    $("body").on("change", 'select[name*="filter_"]', function() {
        var search = $(this);
        //peagando a rota do data action - search.data('data'),
        //search:search.val() - varaiavel que iremos enviar com o nome search
        //function(response) - reposta que vamos obter

        $.post(
            search.data("action"),
            { search: search.val() },
            function(response) {
                console.log(response);
            },
            "json"
        );
    });
});
