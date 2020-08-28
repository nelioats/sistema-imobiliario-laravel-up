$(function() {
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
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        var search = $(this);
        //peagando a rota do data action - search.data('data'),
        //search:search.val() - varaiavel que iremos enviar para controlador com o nome search
        //function(response) - reposta que vamos obter
        var nextIndex = $(this).data("index") + 1;

        $.post(
            search.data("action"),
            { search: search.val() },
            function(response) {
                //se obtivermos resposta com sucesso do controlador
                //vamos inserir o data-index em todos os selects da pagina home
                //definindo a variavel nextIndex para capturar o proximo select

                if (response.status === "success") {
                    //limpando o select pegando o proximo select
                    $('select[data-index="' + nextIndex + '"]').empty();

                    //criar um loop para percorrer o reposnse recebido criando os options do select
                    $.each(response.data, function(key, value) {
                        $('select[data-index="' + nextIndex + '"]').append(
                            $("<option>", {
                                value: value,
                                text: value
                            })
                        );
                    });

                    //zerando todos os outros selects pelo data-index e acrescentando um teto default
                    $.each($('select[name*="filter_"]'), function(
                        index,
                        element
                    ) {
                        if ($(element).data("index") >= nextIndex + 1) {
                            $(element)
                                .empty()
                                .append(
                                    $("<option>", {
                                        text: "Selecione o filtro anterior",
                                        disabled: true
                                    })
                                );
                        }
                    });

                    //dando refresh no plugin selectpicker para poder aplicar nossos scritps
                    $(".selectpicker").selectpicker("refresh");
                }

                //caso o response seja fail
                if (response === "fail") {
                    if ($(element).data("index") >= nextIndex) {
                        $(element)
                            .empty()
                            .append(
                                $("<option>", {
                                    text: "Selecione o filtro anterior",
                                    disabled: true
                                })
                            );
                    }
                    $(".selectpicker").selectpicker("refresh");
                }
            },
            "json"
        );
    });
    //quando todo script for executado, temos que remove-lo para poder a api google maps funcionar
    //console.log($.ajaxSettings);

    //delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
});
