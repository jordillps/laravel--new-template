@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" class="header-container">
    {{-- Logo personalizado --}}
    <img src="{{ config('app.url') }}/media/logo/logoFormalWeb_8.png" 
         alt="{{ config('app.name') }} Logo" 
         class="custom-logo">
    
    {{-- Título de la aplicación --}}
    <div class="app-title">
        {{ config('app.name') }}
    </div>
</a>
</td>
</tr>
