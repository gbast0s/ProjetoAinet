<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Message</title>
    <style>
        h1, h2, h3, h4, h5, h6, a, p, label {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <h1>MagicShirts</h1>
    <h3>A encomenda #{{$encomendaId}} está a ser processada</h3>
    <h4>Nome da encomenda: {{$nome_encomenda}}</h4>
    <h4>Total: {{$preco}} €</h4>
    <h4> Detalhes da Compra </h4>
    @foreach($items as $item)
        <p>
            <label>T-shirt: {{$item->cor->nome}} | Estampa: {{$item->estampa->nome}} | Tamanho: {{$item->tamanho}} | Quantidade: {{$item->quantidade}}</label>
        </p>
    @endforeach
</body>
</html>
