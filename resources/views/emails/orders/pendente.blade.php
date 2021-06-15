<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Message</title>
</head>
<body>
    <h1>A encomenda # {{$encomendaId}} está a ser processada</h1>
    <h3>Nome da encomenda: {{$nome_encomenda}}</h3>
    <h3>Total: {{$preco}} €</h3>
    <h3> Detalhes da Compra </h3>
    @foreach($items as $item)
        <p>
            <label>T-shirt: {{$item->cor->nome}} | Estampa: {{$item->estampa->nome}} | Tamanho: {{$item->tamanho}} | Quantidade: {{$item->quantidade}}</label>
        </p>
    @endforeach
</body>
</html>