<x-app-layout>
    @if(Auth::user()->role_id==2)
    <a class="btn-solid ver-mi-tienda" href="{{ url('dashboard/' . Auth::user()->id) }}">Ver mi tienda</a>
    @endif

    <div class='columns is-mobile is-gapless is-multiline products'>
        <div class='column is-6-fullhd is-6-desktop  is-12-tablet  is-12-mobile'>
            @if(Auth::user()->role_id==2)
            <h3 class="carpet">Mensajes enviados</h3>
            <div class="globalMensajes">
                @forelse($mensajes as $mensaje)
                <div>
                    <p class="fecha">{{ $mensaje->created_at }}</p>
                    <p class="para">{{ $mensaje->to }}</p>
                    <p class="mensaje">{{ $mensaje->message }}</p>
                </div>
                @empty
                <div>
                    <p class="fecha"></p>
                    <p class="para">Sin mensajes</p>
                    <p class="mensaje">No hay interacciones aún</p>
                </div>
                @endforelse
            </div>
            @else
            <h3 class="carpet">Mensajes recibidos</h3>
            <div class="globalMensajes">
                @foreach($mensajes as $mensaje)
                <div>
                    <p class="fecha">{{ $mensaje->created_at }}</p>
                    <p class="para">{{ $mensaje->from }}</p>
                    <p class="mensaje">{{ $mensaje->message }}</p>
                </div>
                @endforeach
            </div>
            @endif



        </div>
        <div class='column is-6-fullhd is-6-desktop  is-12-tablet  is-12-mobile'>
            @if(Auth::user()->role_id==1)

            <h2 class="carpet">Feriantes</h2>
            <div class="list-master">
                @forelse($vendedores as $vendedor)
                <div class="list-space">
                    <p>{{ $vendedor->name }}</p>
                    <p><strong>{{ $vendedor->rubro }}</strong></p>
                    <a class="btn-transparent" href="{{ url('dashboard/' . $vendedor->id) }}">Ver tienda</a>
                </div>
            </div>

            @empty
            <p>Sin feriantes por el momento</p>
            @endforelse

            @endif
            @if(Auth::user()->role_id==2)
            <div class="consejo">
                <h1>Consejo del día</h1>
                <p>Los chistes son mejores cuandos son chistosos.</p>
            </div>
            @endif

        </div>
    </div>


    <!--  -->
    @if(Auth::user()->role_id==1)

    <h2 class="carpet">Pedidos</h2>
    <div class="pedidos">
        @forelse ($pedidos as $pedido)


        <div class="slide-pedidos" id="slidePedido{{ $pedido->id }}">
            <p>{{ $pedido->id }}</p>
            <p>{{ $pedido->nombre_cliente }}</p>
            <p>Id vendedor: {{ $pedido->id_vendedor }}</p>
            <p><strong>{{ $pedido->estado }}</strong></p>
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
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(json_decode($pedido->productos,false) as $product)

                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td><img src="{{ $product->img }}" alt="{{ $product->name }}" style="height:20px !important;"></td>
                                        <td>{{ $product->cantidad }}</td>
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
                <a class="btn-solid" style="background-color: blue">paypal</a>
                <a id="open{{ $pedido->id }}" class="btn-square">Ver</a>
                <a class="btn-estado" id="delete{{ $pedido->id }}" data-id="{{ $pedido->id }}">Eliminar</a>
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
                $("body").on("click", "#delete{{ $pedido->id }}", function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    let changeStatus = $('#delete{{ $pedido->id }}');
                    changeStatus.addClass('button is-loading');
                    $.ajax({
                        type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
                        url: "{{ route('pedido.delete') }}", //url guarda la ruta hacia donde se hace la peticion
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: changeStatus.attr('data-id'),
                        }, // data recive un objeto con la informacion que se enviara al servidor
                        success: function(datos) { //success es una funcion que se utiliza si el servidor retorna informacion
                            $('#slidePedido{{ $pedido->id }}').parent().parent().attr("style", "background-color:red !important;");
                            setTimeout(function() {
                                $('#slidePedido{{ $pedido->id }}').parent().parent().hide('3000');

                            }, 1000);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    }).fail(function(jqXHR, textStatus, error) {
                        // Handle error here
                        console.log(jqXHR.responseText);
                    });
                });

                // function changeStatus(estado, id) {
                // onclick="changeStatus('{{ $pedido->estado }}','{{ $pedido->id }}')"
                // };
            </script>


        </div>
        @empty
        <p>¿Aún no pides nada?</p>
        @endforelse

    </div>
    @endif
    <!--  -->



    <script>
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