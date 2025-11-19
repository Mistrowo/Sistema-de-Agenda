<div class="container">
    <div class="side-content">
    

    
    </div>
    <div class="main-title">AGENDA INSTALACIONES</div>
    <div class="side-content">
    <div class="info">Fecha: <span>{{ session('fecha', 'Fecha no disponible') }}</span></div>
    <div class="info">Usuario: <span>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</span></div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="boton-inicio">Cerrar Sesión</button>
    </form>
</div>
</div>