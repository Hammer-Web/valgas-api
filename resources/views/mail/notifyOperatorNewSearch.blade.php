@component('mail::message')

# Olá {{$user->usu_nome}}
## Nova pesquisa para análisar

### Pesquisa: #{{$search->id}}

@component('mail::button', [
        'url' => env('URL_VALGAS').'/administracao/minhas-pesquisas',
        'color' => 'success'
    ])
        Ver minhas pesquisas
@endcomponent

@endcomponent
