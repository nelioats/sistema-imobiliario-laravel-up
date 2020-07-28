@extends('web.master.master')


@section('content')
    


<div class="main_filter bg-light py-5">
    <div class="container">
        <section class="row">
            <div class="col-12">
                <h2 class="text-front icon-filter mb-5">Filtro</h2>
            </div>

            <div class="col-12 col-md-4">
                <form action="" class="w-100 p-3 bg-white mb-5">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="search" class="mb-2 text-front">Comprar ou Alugar?</label>
                            <select class="selectpicker" id="search" name="search" title="Escolha...">
                                <option value="buy">Comprar</option>
                                <option value="rent">Alugar</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="category" class="mb-2 text-front">O que você quer?</label>
                            <select class="selectpicker" id="category" name="category" title="Escolha...">
                                <option value="">Imóvel Residencial</option>
                                <option value="">Comercial/Industrial</option>
                                <option value="">Terreno</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="type" class="mb-2 text-front">Qual o tipo do imóvel?</label>
                            <select class="selectpicker input-large" id="type" name="type" multiple
                                    data-actions-box="true">
                                <option value="">Casa</option>
                                <option value="">Apartamento</option>
                                <option value="">Terreno</option>
                                <option value="">Sala Comercial</option>
                                <option value="">Galpão</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="search_locale" class="mb-2 text-front">Onde você quer?</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha..." multiple
                                    data-actions-box="true">
                                <option value="">Campeche</option>
                                <option value="">Rio Tavares</option>
                                <option value="">Morro das Pedras</option>
                                <option value="">Pântano do Sul</option>
                                <option value="">Matadeiro</option>
                                <option value="">Armação</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="bedrooms" class="mb-2 text-front">Quartos</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha...">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4+</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="bedrooms" class="mb-2 text-front">Suítes</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha...">
                                <option value="">0</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4+</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="bedrooms" class="mb-2 text-front">Banheiros</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha...">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4+</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="bedrooms" class="mb-2 text-front">Garagem</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha...">
                                <option value="">0</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4+</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="bedrooms" class="mb-2 text-front">Preço Base</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha...">
                                <option value="">A partir de R$ 100.000,00</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4+</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="bedrooms" class="mb-2 text-front">Preço Limite</label>
                            <select class="selectpicker" name="bedrooms" id="bedrooms" title="Escolha...">
                                <option value="">Até R$ 1.000.000,00</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4+</option>
                            </select>
                        </div>

                        <div class="col-12 text-right mt-3 button_search">
                            <button class="btn btn-front icon-search">Pesquisar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12 col-md-8">

                <section class="row main_properties">

                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <article class="card main_properties_item">
                            <div class="img-responsive-16by9">
                                <a href="">
                                    <img src="properties/1/5a3571ab-4d76-466f-8246-eff8cb98cedd.jpg"
                                         class="card-img-top"
                                         alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <h2><a href="" class="text-front">Linda Casa no Campeche com vista para o Morro do
                                        Lampião</a>
                                </h2>
                                <p class="main_properties_item_category">Imóvel Residencial</p>
                                <p class="main_properties_item_type">Casa - Campeche <i
                                            class="icon-location-arrow icon-notext"></i></p>
                                <p class="main_properties_price text-front">R$ 1.500,00/mês</p>
                                <a href="" class="btn btn-front btn-block">Ver Imóvel</a>
                            </div>
                            <div class="card-footer d-flex">
                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/bed.png" class="img-fluid" alt="">
                                    <p class="text-muted">4</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/garage.png" class="img-fluid" alt="">
                                    <p class="text-muted">2</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/util-area.png" class="img-fluid" alt="">
                                    <p class="text-muted">1500 m&sup2;</p>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <article class="card main_properties_item">
                            <div class="img-responsive-16by9">
                                <a href="">
                                    <img src="properties/1/5a3571ab-4d76-466f-8246-eff8cb98cedd.jpg"
                                         class="card-img-top"
                                         alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <h2><a href="" class="text-front">Linda Casa no Campeche com vista para o Morro do
                                        Lampião</a>
                                </h2>
                                <p class="main_properties_item_category">Imóvel Residencial</p>
                                <p class="main_properties_item_type">Casa - Campeche <i
                                            class="icon-location-arrow icon-notext"></i></p>
                                <p class="main_properties_price text-front">R$ 1.500,00/mês</p>
                                <a href="" class="btn btn-front btn-block">Ver Imóvel</a>
                            </div>
                            <div class="card-footer d-flex">
                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/bed.png" class="img-fluid" alt="">
                                    <p class="text-muted">4</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/garage.png" class="img-fluid" alt="">
                                    <p class="text-muted">2</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/util-area.png" class="img-fluid" alt="">
                                    <p class="text-muted">1500 m&sup2;</p>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <article class="card main_properties_item">
                            <div class="img-responsive-16by9">
                                <a href="">
                                    <img src="properties/1/5a3571ab-4d76-466f-8246-eff8cb98cedd.jpg"
                                         class="card-img-top"
                                         alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <h2><a href="" class="text-front">Linda Casa no Campeche com vista para o Morro do
                                        Lampião</a>
                                </h2>
                                <p class="main_properties_item_category">Imóvel Residencial</p>
                                <p class="main_properties_item_type">Casa - Campeche <i
                                            class="icon-location-arrow icon-notext"></i></p>
                                <p class="main_properties_price text-front">R$ 1.500,00/mês</p>
                                <a href="" class="btn btn-front btn-block">Ver Imóvel</a>
                            </div>
                            <div class="card-footer d-flex">
                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/bed.png" class="img-fluid" alt="">
                                    <p class="text-muted">4</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/garage.png" class="img-fluid" alt="">
                                    <p class="text-muted">2</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/util-area.png" class="img-fluid" alt="">
                                    <p class="text-muted">1500 m&sup2;</p>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <article class="card main_properties_item">
                            <div class="img-responsive-16by9">
                                <a href="">
                                    <img src="properties/1/5a3571ab-4d76-466f-8246-eff8cb98cedd.jpg"
                                         class="card-img-top"
                                         alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <h2><a href="" class="text-front">Linda Casa no Campeche com vista para o Morro do
                                        Lampião</a>
                                </h2>
                                <p class="main_properties_item_category">Imóvel Residencial</p>
                                <p class="main_properties_item_type">Casa - Campeche <i
                                            class="icon-location-arrow icon-notext"></i></p>
                                <p class="main_properties_price text-front">R$ 1.500,00/mês</p>
                                <a href="" class="btn btn-front btn-block">Ver Imóvel</a>
                            </div>
                            <div class="card-footer d-flex">
                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/bed.png" class="img-fluid" alt="">
                                    <p class="text-muted">4</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/garage.png" class="img-fluid" alt="">
                                    <p class="text-muted">2</p>
                                </div>

                                <div class="main_properties_features col-4 text-center">
                                    <img src="assets/images/icons/util-area.png" class="img-fluid" alt="">
                                    <p class="text-muted">1500 m&sup2;</p>
                                </div>
                            </div>
                        </article>
                    </div>

                </section>
            </div>
        </section>
    </div>
</div>







@endsection