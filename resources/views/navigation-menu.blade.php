<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ url('image/frutas.png') }}" width="65" height="100" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('home-space') }}" :active="request()->routeIs('home-space')">
                        {{ __('Home') }}
                    </x-jet-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                    {{ Auth::user()->currentTeam->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <!-- Team Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Team') }}
                                </div>

                                <!-- Team Settings -->
                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-jet-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-jet-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-100"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" />
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ Auth::user()->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Perfil') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Salir') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @if(Auth::user()->role_id==1)
                <img src="{{ url('image/carrito.png') }}" alt="Carrito Compras" width="30" height="30" onclick="verCarrito()" />
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('home-space') }}" :active="request()->routeIs('home-space')">
                {{ __('Home') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="flex-shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Perfiles') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Cerrar Sesi??n') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                    {{ __('Team Settings') }}
                </x-jet-responsive-nav-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                    {{ __('Create New Team') }}
                </x-jet-responsive-nav-link>
                @endcan

                <div class="border-t border-gray-200"></div>

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>

<div id="eg1_modal_carrito" class="eg1_modal" style="position: absolute;
                                                         top: 5%;">
    <a onclick="eg1CloseModal(`eg1_modal_carrito`)" class="close_modal_eg1">x</a>
    <div id="eg1_cont" class="eg1_cont">
        <div>
            <div id="productInfo">

            </div>
        </div>
        <a class="btn-solid" onclick="limpiarCarrito()">Limpiar</a>
        <br><br>
        <a class="btn-solid" onclick="pagar(idClient)" id="completarPedido">Completar pedido</a>
        <div id="paypal-button-container"></div>
    </div>
</div>
<script src="https://www.paypal.com/sdk/js?client-id=AacMOVOzR9wnDMogi6Wyodaxa8u9XYeD2yRhy6KX6Upt44NaTH9HjMA7ZVKtn0C8PKFFClVprp4Um6GG&locale=es_CL&components=buttons"></script>

<script>
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color: 'blue',
            shape: 'rect',
            label: 'paypal'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '0.1',
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                alert('Transanccion Completada ' + details.payer.name.given_name);
                pagar();
            });
        },
        onCancel: function(data) {
            // Show a cancel page, or return to cart
            alert('Transanccion Rechazada');
        },
        onError: function(err) {
            // For example, redirect to a specific error page
            alert('Transanccion Con Error');
        }
    }).render('#paypal-button-container');

    function limpiarCarrito() {
        localStorage.removeItem('carrito');
        eg1CloseModal(`eg1_modal_carrito`);
        alert('Se eliminaran los productos del carro de compras.');

    }

    function verCarrito() {

        if (localStorage.getItem('carrito') === null) {
            alert('No hay productos en el carro de compras.');
            return;
        }


        var products_list = JSON.parse(localStorage.getItem('carrito'));

        if (products_list.length === 0) {
            alert('No hay productos en el carro de compras.');
            return;
        }

        let html = '';
        let precio = 0;
        for (let producto of products_list) {
            let pp = producto.price.replace(".", "").replace("$", "");
            precio = precio + (parseInt(pp) * parseInt(producto.cantidad));

            html = html + '<img width="50" height="50" src="' + producto.img + '" alt="" id="imgInfo" class="centrar">' +
                '<p><strong>Nombre:</strong><span>' + producto.name + '</span></p>' +
                '<p><strong>precio:</strong><span>' + producto.price + '</span></p>' +
                //'<p><strong>Descripci??n:</strong><span>'+producto.description+'</span></p>'+
                '<p><strong>Cantidad:</strong><span>' + producto.cantidad + '</span></p>';
        }

        html = html + '<br><p id="totalpagar" data-total="' + precio.toLocaleString().split(',')[0] + '"><strong>Total a Pagar :</strong><span> $' + precio.toLocaleString().split(',')[0] + '</span></p>';

        $('#productInfo').html(html);

        eg1OpenModal('eg1_modal_carrito');

    }

    function pagar(idClient) {
        var products_list = JSON.parse(localStorage.getItem('carrito'));
        let productoss = [{

            // $table->string('id_vendedor');
            // $table->string('precio_total');
            // $table->string('estado');
            // $table->json('productos');
            "id_client": '{{ Auth::user()->id }}',
            "name_client": '{{ Auth::user()->name }}',
            "direction_client": '{{ Auth::user()->direction_client }}',
            "id_vendedor": idClient,
            "precio_total": $('#totalpagar').attr("data-total"),
            "estado": "activo",
            "products": products_list,
        }];

        $.ajax({
            type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
            url: "{{ route('pedido.add') }}", //url guarda la ruta hacia donde se hace la peticion
            data: {
                "_token": "{{ csrf_token() }}",
                products: productoss,
            }, // data recive un objeto con la informacion que se enviara al servidor
            success: function(datos) { //success es una funcion que se utiliza si el servidor retorna informacion
                localStorage.removeItem('carrito');
                eg1CloseModal(`eg1_modal_carrito`);
                location.reload();
                $('#completarPedido').addClass('button is-loading');
            },
            error: function(error) {
                console.log(error);
            }
        }).fail(function(jqXHR, textStatus, error) {
            // Handle error here
            console.log(jqXHR.responseText);
        });

        // $.ajax({
        //     type: 'post',
        //     url: "{{ route('pedido.add') }}",
        //     data: {
        //         products: products_list,
        //     },
        //     success: function(data) {

        //         alert("pedido completado");
        //     },
        //    
    }
</script>