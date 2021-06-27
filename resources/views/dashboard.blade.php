<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pagina Principal') }}
        </h2>
    </x-slot>
    <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
        <img src="./image/logo-2.png" style="filter: opacity(.2);" width="100px">
        </img>
    </div>



    @if(Auth::user()->role_id==2)

    <div class="pedidos">
        @foreach ($pedidos as $pedido)

        <div class="slide-pedidos">
            <p>{{ $pedido->nombre_cliente }}</p>
            <p>{{ $pedido->estado }}</p>
            <p>{{ $pedido->created_at }}</p>
            <p>{{ $pedido->direccion_cliente }}</p>
            <p>${{ $pedido->precio_total }}</p>
            <div class="pedidoID" id="pedido{{ $pedido->id }}">
                <p style="float:left;">Cliente: {{ $pedido->nombre_cliente }}</p>
                <p class="close_pedido" id="close{{ $pedido->id }}">[x]cerrar</p>
                <hr>
                <div class="columns">
                    <div class="column">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th></th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(json_decode($pedido->productos,false) as $product)

                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td><img src="{{ $product->img }}" alt="{{ $product->name }}" style="height:20px !important;"></td>
                                        <td>{{ $product->cantidad }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->description }}</td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-pedido">
                <a id="open{{ $pedido->id }}" class="btn-transparent">Ver</a>
                <a class="btn-estado">RECIBIR</a>
            </div>
            <script>
                $("body").on("click", "#close{{ $pedido->id }}", function() {
                    let pedido = $('#pedido{{ $pedido->id }}');
                    pedido.slideUp('slow');
                });
                $("body").on("click", "#open{{ $pedido->id }}", function() {
                    let pedido = $('#pedido{{ $pedido->id }}');
                    pedido.slideDown('slow');
                });
            </script>


        </div>
        @endforeach

    </div>
    @endif

    <div class='columns is-mobile is-gapless is-multiline products'>
        @if(Auth::user()->role_id==2)

        <div class='column is-2-fullhd is-2-desktop  is-4-tablet  is-4-mobile  product-add'>
            <div class='centrar-full' onclick="formProduct(true);eg1OpenModal('eg1_modal');">
                <p class='_title-1'>+</p>
            </div>
        </div>
        @endif
        @foreach ($data as $product)
        <div class='column is-2-fullhd is-2-desktop  is-4-tablet  is-4-mobile '>

            <div class="product-on">
                <div class="product-img">
                    <div style="width:100%;height:100px;">
                        <img class="centrar" src="{{ $product->img_url }}" height="100%" alt="">
                    </div>
                    <p class="text-center">{{ $product->name }}</p>
                    <p class="text-center" style="height: 32px; overflow: hidden;">{{ $product->description }}</p>
                    <a onclick="cargarVer('{{ $product->id }}')" class="btn-ver">Ver</a>
                    @if(Auth::user()->role_id==2)
                    <form method='get' action="{{ route('product.del') }}">
                        @csrf
                        <input type="hidden" name="idDelete" value="{{ $product->id }}"> <br>
                        <button type="submit" class="btn-square"> Borrar</button>
                    </form>
                    @endif
                </div>
            </div>

        </div>
        @endforeach

    </div>


    <div id="eg1_modal" class="eg1_modal" style="top: 10%;">
        <a onclick="eg1CloseModal(`eg1_modal`)" class="close_modal_eg1">x</a>
        <div id="eg1_cont" class="eg1_cont">
            <div>
                @if(Auth::user()->role_id==2)

                <form method='post' action="{{ route('product.add') }}" id="formProduct">
                    @csrf
                    <h3>Agregar</h3>
                    <input type="text" name="name" placeholder="nombre"> <br>
                    <input type="text" name="description" placeholder="descripcion"> <br>
                    <input type="number" name="price" placeholder="precio"> <br>
                    <input type="text" name="img_url" placeholder="imagen url"> <br>
                    <!-- <input type="check" name="active" placeholder="activo"> <br>
                <input type="number" name="order" placeholder="orden"> <br> -->
                    <button type=" submit" class="btn-solid">[+]Agregar</button>
                </form>
                <form method='get' action="{{ route('product.edit') }}" id="editProduct">
                    @csrf
                    <h3>Actualizar</h3>
                    <input type="hidden" name="idinput" value="" id="idedit"> <br>
                    <input type="text" name="name" placeholder="nombre"> <br>
                    <input type="text" name="description" placeholder="descripcion"> <br>
                    <input type="number" name="price" placeholder="precio"> <br>
                    <input type="text" name="img_url" placeholder="imagen url"> <br>

                    <button type="submit" class="btn-solid">Actualizar</button>
                </form>

                @endif
                <div id="productInfo2">
                    @if(Auth::user()->role_id==1)
                    <input type="hidden" name="idproductcarrito" value="" id="idproductcarrito"> <br>
                    @endif
                    <p><strong>Nombre:</strong><span id="nameInfo"></span></p>
                    <p><strong>precio:</strong>$<span id="priceInfo"></span></p>
                    <img src="" alt="" id="imgInfo" class="centrar">
                    <p><strong>Descripción:</strong><span id="descriptionInfo"></span></p>
                    @if(Auth::user()->role_id==1)
                    <input type="number" name="cantidad" id="cantidad" placeholder="cantidad" style="margin:10px 0 10px 0" size>
                    <a class="btn-solid" onclick="agregarCarrito()">Agregar</a>
                    @endif
                    @if(Auth::user()->role_id==2)
                    <a class="btn-solid" onclick="editProduct(true);eg1OpenModal('eg1_modal');">Modificar</a>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <script>
        // var toAdd = [];
        // localStorage.setItem("carrito", JSON.stringify(toAdd));
        // var lleno = JSON.parse(localStorage.getItem("carrito"));


        function agregarCarrito() {

            if (localStorage.getItem("carrito") === null) {
                let carrito = [];
                localStorage.setItem("carrito", JSON.stringify(carrito))
            }

            let producto = {
                id: $('#idproductcarrito').val(),
                cantidad: $('#cantidad').val(),
                name: $('#nameInfo').text(),
                price: $('#priceInfo').text(),
                description: $('#descriptionInfo').text(),
                img: $('#imgInfo').prop('src')
            }

            var products_list = JSON.parse(localStorage.getItem('carrito'));
            products_list.push(producto);
            localStorage.setItem("carrito", JSON.stringify(products_list));

            eg1CloseModal('eg1_modal');

        }

        function cargarVer(id) {
            $('.btn-ver').addClass('button is-loading');
            $.ajax({
                type: 'GET',
                url: "{{ route('product.get') }}",
                data: {
                    id: id,
                },
                success: function(data) {
                    $('.btn-ver').removeClass('is-loading');

                    $('#nameInfo').text(data[0].name);
                    $('#priceInfo').text(data[0].price);
                    $('#descriptionInfo').text(data[0].description);
                    $('#imgInfo').attr('src', data[0].img_url);

                    $('#idproductcarrito').attr('value', id);
                    $('#idedit').attr('value', id);

                    clearModal();
                    let info = $('#productInfo2');
                    if (info.css("display") == "none") {
                        info.css("display", "block");
                    }
                    eg1OpenModal('eg1_modal');
                },
                error: function(error) {
                    console.log(error);
                }
            }).fail(function(jqXHR, textStatus, error) {
                // Handle error here
                console.log(jqXHR.responseText);
            });

        }

        function formProduct(active = true) {
            clearModal();
            if (active == true) {
                let form = $('#formProduct');
                if (form.css("display") == "none") {
                    form.css("display", "block");
                }
            }
        }

        function editProduct(active = true) {
            clearModal();
            if (active == true) {
                let edit = $('#editProduct');
                if (edit.css("display") == "none") {
                    edit.css("display", "block");
                }
            }


        }

        function clearModal() {
            let form = $('#formProduct');
            form.css("display", "none");

            let info = $('#productInfo2');
            info.attr("style", "display:none !important");

            let edit = $('#editProduct');
            edit.css("display", "none");
        }
        clearModal();

        $(".pedidos").slick({
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    </script>




</x-app-layout>