<x-app-layout>
    @if(Auth::user()->role_id==1)
    <a class="btn-solid" href="{{ url('dashboard/' . Auth::user()->id) }}">Ver mi tienda</a>
    @endif

    <div class='columns is-mobile is-gapless is-multiline products'>
        <div class='column is-6-fullhd is-6-desktop  is-12-tablet  is-12-mobile'>
            @if(Auth::user()->role_id==2)
            <h3>Mensajes enviados</h3>
            @else
            <h3>Mensajes recibido</h3>
            @endif


            <div class="globalMensajes">
                @foreach($mensajes as $mensaje)
                <div>
                    <p class="fecha">{{ $mensaje->created_at }}</p>
                    <p class="para">{{ $mensaje->to }}</p>
                    <p class="mensaje">{{ $mensaje->message }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class='column is-6-fullhd is-6-desktop  is-12-tablet  is-12-mobile'>
            @if(Auth::user()->role_id==1)

            <h2>Feriantes</h2>
            <div class="list-master">
                @forelse($vendedores as $vendedor)
                <div class="list-space">
                    <p>{{ $vendedor->name }}</p>
                    <p>{{ $vendedor->rubro }}</p>
                    <a href="{{ url('dashboard/' . $vendedor->id) }}">Ver tienda</a>
                </div>
            </div>

            @empty
            <p>Sin feriantes por el momento</p>
            @endforelse

            @endif
        </div>
    </div>



</x-app-layout>