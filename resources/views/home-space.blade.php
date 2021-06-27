<x-app-layout>

    @if(Auth::user()->role_id==2)
    <a class="btn-solid" href="{{ url('dashboard/' . Auth::user()->id) }}">Ver mi tienda</a>
    @endif
    <h2>Mensajes</h2>
    <div>

    </div>



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



</x-app-layout>