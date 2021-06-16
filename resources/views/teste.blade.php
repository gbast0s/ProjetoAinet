<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Message</title>
    <style>
        body{
            margin-top:20px;
            background:#eee;
            font-family: 'Roboto', sans-serif;
        }

        .invoice {
            padding: 30px;
        }

        .invoice h2 {
            margin-top: 0px;
            line-height: 0.8em;
        }

        .invoice .small {
            font-weight: 300;
        }

        .invoice hr {
            margin-top: 10px;
            border-color: #ddd;
        }

        .invoice .table tr.line {
            border-bottom: 1px solid #ccc;
        }

        .invoice .table td {
            border: none;
        }

        .invoice .identity {
            margin-top: 10px;
            font-size: 1.1em;
            font-weight: 300;
        }

        .invoice .identity strong {
            font-weight: 600;
        }

        .grid {
            position: relative;
            width: 100%;
            background: #fff;
            color: #666666;
            border-radius: 2px;
            margin-bottom: 25px;
            box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
        }

        .line td {
            border: 1px solid black;
        }
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="grid invoice">
                    <div class="grid-body">
                        <div class="invoice-title">
                            <div class="row">
                                <div class="col-xs-12">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJ0AAAAyCAYAAABGbNntAAAYHklEQVR4nO1cC1gU173/ze7smwWWNwgIi6j4QBQUcSFKAjZGEpt4NelNmrTVYuKXmJu2uaa9bW+S27SaprdN095Gak2jMS+TNMb4jK8IqCgLKmoU5f1+7cI+2PfO/c44QycrCChpI92f3/lYZ86ZOXPOb/6v8z8DP/zww49xD2rVqlUDz8gwDFQqFZqbm2EwGBAYGAiaptHX1we3282e7+rqgkKhUDqdznSDwZDPMMwUuVwe5XA4Il0ul0osFptdLlebQqFoDQ4OPhwWFvah2Ww22Ww2PPvss0hISIDZbB7RuJK+XLlyBe+++y5SU1ORkZEBl8vF9kOI1atX+5n6NQdFUQMdpG/UVTK5EokEarUanZ2dMJlMK9vb259yu91ZLpdL7PV62TqkkIuKxWKQYyKRKIUQtb29/RGFQrEFwJ6oqKgnQkNDG8PDw9lrjgSE9N3d3eDv48f4wA1JR8hmt9vR0tLyeFVV1f8wDBPGnyMEI8UX/DH+r9PphMfjuaeurq5hz5498xITE0+PVNIRchKJK5PJCJH9lBsnuI50vEQhqq2vr296cXHxTqvVmkTULCGSUEyOBKSdVCqF1WrF559/ntvT0zMi0pF+kHYNDQ0ICwsblOB+3J6gieri4fF4WJKEhITgyJEjhY2NjZvIeSJpRks2HryEIiSSy+WztVotent7h21H7kf60t/fz9pxfowf0ESaCCeaSLiKiop1tbW1r5JJVygUo7anSH1CNp6ohLhEUjU3N8+oqalh/y8k+1BktVgscDgcI7YB/bg9QEdFRQ10VKPR4PTp0984duzYq4SMZLJHQzjeoeAJxzsZPIncbncswzAKuVxuu5H0InXJeeIx+9Xq+IOISDJSCOHMZrP0448/3koIM1rCgSMLr059PU5y3Gq1BlssltQbSS5eOhK1yktMP8YXaBIHA2fwe71ep0Qi6aUoKmIkhBPaeULJNlhbIrGIJ9vf35+iUCjKiBQbDJztB6PRyIdf/JQbZ6BjYmLYJyKTHRERQeJxr+3cufM1MtlDEY8nGE868ns4G42v5/F4kkgo5kakUyqVrPNCpJ2fdOMPIkIAUkgglkijOXPmfCCVSl1EKvHgQyU8Cfm/vEMwUjVMrtHR0bGAxN6Ik+BbCBFNJhPa2trYujfrMfvx9QZdX1//pQ5qNJp2rVb7/qVLlx7m7TqhVLqVlQFC3t7e3gQSpyMSjIRoyPX4GCAhGylkqYwc82N8QhQaGgq+kPgcCcTm5OT8BZwkG0twXmmsx+MJJYQmkozYb8RTttsdMBoNcDrtfsKNc4iI18oXQjpCjMzMzCNTp049ThbpxxKEZA6HQ+p0OuMJ6YjtRnD58mU0NtSDpiVsEYK3Hf2qdvyAPnny5JcehkwykXbBwcHbACwQ2nK3CkJospbLMExKTExMZUtLC5txwoCBRCoF8Rl8b0XIefXqVUybNg2xsbGs7edf/L+9QRMv0RfEidBqtX+rrKz8X6fTqRirFQE2cEwBZ7+4PKePkr3t6emASiGFSqliVx7+DiLdrsX8Ll68KF++fPlxqVR6cuvWrWvJiokv6ZYtW/avM2PjADQJkwwGrVbbUV1d/XZ5efkqYnONlXTxUDRCnMbvazovf1HcS29VaMJdYRIPAmkaFGdDEhVLwiXFxcWRW7ZsObls2bKExx57TE/SpYinza9S+Ndkb0/QdXV1A6lDfAiESDaSFRIeHv66SCRaRY6NmU3lZaCWigPfWRa3ubjetPlwm3n/2W7H1uJuZp9UJjdEQQSKYe83f8+ePcczMzOpnJycdRMmTHht3bp1bKoTISRR04NJaSH02dka8t/0khLjUHX45yrX6TQZpaVD1hsLlOt0eQA2ANiRUVq68RYuqRH8HqzPm8hjA8gYwbXKyVABWHMzHbkZYSQi9huvPonXSCaSkIysCCQnJ5enTJu2dywdCkosRllzH7yUCHcvSsTLd4Z94695mu1vZit6HgizbY0PUyt27tl/b0RM7InYuDgqKyurIEijeY308+zZsygpKcGHH36I8+fP3zDPTp+dvQKAgRTu95Ao1+nIwBvKdboNY/agg4OQJd2HNKPBCo4kBkH5jLumEOkjvI9GUHe0z3HTEOXk5LBeKyEcUV0ks7ejowMulxPTZsxCv9NVQS4+Vr6jREwW/r3YXtkOW7MFgBTR8RFYkZuALd9N+Xa4tc3k6Ld88sZftiDtznumy4LDdwerVbhQVcWS7fTp02htbR3IVB6hBB6SdJz0Ge2g3xQySkt3AAjJKC197ibak2d4n/tNpNJKAM9xfSfE097ENYmUDBmhROTBk/6miSciUo0Ef0lhU5CImqVotPTZcbGi7Il4keW/AlUqONy3HrNjVbjbCXhdeOKDM0jYcAS5/3ccr+2rhqPbiae3lONtfT2dHh2IC8/e4fz9XTGv2LpaHtpzoQlNVjdokQhBQYHsy0HINorVkBX67OyhJqXwlh9sFLgFFb6e+0vIVkRUNICN3P81nNq+GXylJsVgoMmqAMWvo3o96HV44LJbc61fnH7+XO+kO+ZEB6ChoxcmBwMZdX1IYyQgZCMqmtyLYN26p3Dg0BFcunAenUYTjtZ048e7L8DqcCJ3Ujj2P5EDiVoiTYmQL7k7Xr5kZ03/Lz+t6dt4pKanKDg0hEkKU7Mvxwih56TBCm6SBsDZfHncwA/65pbrdCt8JCGxx/TD1DMSm61cpyO2VS1vv5XrdIT4hOR6TuoJ268X9ME4iM03cM7n+EGOgEORR3hdPVdXiA1cW/5+fB/5eiu4dnruuEZwXWE7wiHfsSpiGKbWt0Mi8Fm6FIO6HjPeP1YWOMne9ObDie47ovuuoMoowtI7cxCkkMDh8gzxXF8Gr/JIGIQY/SS2RghXUFCAXbt24dVXf4/5c69JdLU6ACKKYQkXFKDCZ4RwEgoNTUa09nkQExKIZ5YmJv4mU/H62sVppoJZE186X9cWYfLSCFDIIRYPS76DggHzBT+IvhPBgiPN+9zA53H1y8t1ukKfeuu5eoV8Pc5OLPQhM5mQ9cKJIQ4MV3cD15Z1Nsgxck7Qlp+8wZ5j5RCOwCafvr8vkJjg+rbex/zg+7iJU6V5XD2t4De43wPag6KoQceKoqjr+svOGE2L0A0FrtQ3zv11srnhjW/PiYubnAax04kZMiMMHS2weSmQf0J1JkxlIt4kIRgpxPMlfwnRyNbBtWvXsvbY9u3bWeIRECJe+2tl1aRUoYLZBZxq6AZcHsjEItaOdHmBlgt1OOMIwh9+sipg6++f/smPl8zoMF6ueKm+owfmfvsgY30dCKm0+uzsPJ8TedxkHvRtwNl6hZxkS8ooLc3gbB+jcOI4YvBvfQapR+pzRB8JeBI+x7XNENhqQoKs4e6xgbPh1o/AjtNzfR6078NAI2hXxI1RhoD8+TzRKYoaGCuGYZIYhsngzmOw+9EqmQQdHjma6qru+VOaY/fiWfGw2zxYOjMWs2JD8IdDZ/FOWRVEUgVoeGGzOQftKjHqk5KSQDKRSewvLS2NZKwgJSUFEydOZB0VQk7iCLzwwgvYvXv3QFuNJhhGkw1SCghTyWHn7EeRiILYacGuBhfm3bcCCFLgqr4GKxJpZNpNP9lc3frGvKyMqyMYwCLu4Qt5gumzs9M50g0VutBzEmSAkBmlpbXlOh0Z9HRBiGUFN0FF5Lyg/cER2ouFQhXM3Wcjp659JV0SJ4EGJCJ3nzUCMvg+t7B9rcCrHc6W2zGKF+c61c8wjJ6iqJWDmS20UaSCufnKw3+c0v2WbkYC2o0eOFxOTIxWw2SXYNM5EysQvU4b0rOy8Oijj7I7tAiJ+J1eQUFBLLFIISlSfOFz8shGnLKyMnz00Ud48803wadNEaIGBqrRb3cCHgd+mDcVydFqtBuscDMMYlUifFTRifjsZZiTPgneNhP2792P7wUb0BSpBmM6u/rcid6XsOpbN9xeRuJ0+uxsMjl5xI7j4nY8IYoG8145Qu0gqpSzxXwHmAd/7jppORy462oGIwwn8Xxh5F4ECFQ5H0bJHwVJ8oYyKW4GDMPsoCiKfckoikrnxuIgwzCDjgl9aO+nGU9pGt7SpU5Ei9EDMbzQKKQwm1y487VjgMsOhUIGm83BBmYLCwuHjI3xnjCx5aqrq9lCMpP37t2Lw4cPf0k1k9hgcKAa3X1WMG4HHs5IxC/vTYHZQtZmKQTLJThf14Lu8BQUZs1knZyPT1Yh1duCps4AmO9QQ2eQpe/e1TIVwOkRjFURN0GFnHRbwalOIr2uIx137H2OVAdHMaGjwc2EOYTPU8QR6DNO6uWPoN1XAoZh8jn7jR/j9RRFkZdpJZF6wnvSzqrDj+Q9nILOPoYlHEFgkByvH76KGoOFDcB6PNf2oJJsEGKfPfLII2yyJZ/6RP4Sm47E92pra9mcuMrKSpZ0PPjN2UTKKciWRoUCXT1GNgL4bP40vLxsGhz9DvTa3RBTIsgZB06ZZMh5YCHZKAlThwW91ZVYqFDigMKLmKQw/Oj1o/Pbe0IWjYR06SUlB/XZ2XoufIIbORAcNnCkWCn0NDlbb6wwJJF9VkgGVjIGMQf4FyJvhGrzKwFFURqGYfgXgfdkN3EvRIjwnnSXU8lU1PZhzpRIGExO2FxukFX5GoOVrcBLJ+KREuJt2rSJLUJpN1TeHV+H3X/h8VxTq1I5bA434OhDhjYcry5NwYLpkTAbrDDZ3ZCIKATIJDhT2wJN0lykaKPY/nxafAwLaSPO2mhkFiZj24EK1Df3KROmRCpHMYg7uMljVVp6SckODB1c5tXogIrgnAZf9coTZ4UPiYcNnhJSlet0rNonqpa3CTm1W0POZZSW5gtsMQxCOt6z1P8TCbeBk2xrOOLxKpc1ATiVO/CC0ekzwqde6uhCo9mDrOQQRKrlJMkDMhHFX/BL3yshxOM/psOD33Io3C5IfpPYHJu46faA8XquOcuMGItTQlE4Pw7LU6PJEgXa2kh6EwlMU2Aggoqx44xFgnmTpwIqKYqPnQddewpBSjVUugA4LA48/8J5JM9N3fRIxgOvj2J8igRe33CrAvxEb+CIoR0kBMKuMpTrdKwE5ZbR9FzdkXqJvIp8v1ynK+KIw9ubPIlruf5u4Oy3HdwxrdCRGcU43Ap4Yhdyz3qQuzevUjWCsSPPpeecioFbiqwasTQwUwWvk0JpVTcq2/pY+2l9/hREqpWsfebk4nM80YjkIjYZX/h0cwIPWyiWcGGaYFxobMOMRd9AIAW8uHQmTj81F/vXZGL53DgYLE60dJpBUQxEFMU6D1EqMfZdbIFyaiZSdTPQcrkV5ft2YmV8MPRiDyQxSizZ+B6gQv/CsMwXrbb+jpEOIOdA8JJrOEN6jcAD5eNbRYI3VmiP5XN11wvqjshQ51T3Go44mwR25JqM0lIhkTYKYnEbuHr8KsSafyDpnhOEbtj7cwHgfMFxfgwODmZnUkgJ+Ew8x5J3MKsAmi4PzlS0IyRIitlJwQiWS/HSoSt45Vgd3E7HdU1ZkegDkYh8ucmD2WlpOFhZiTOHD8P61nPITQhCQGQIYHOh02yH2+NlicaDXClILkV9UzOOeidi7drHAHM/frv5LayZYMLVdhreezT4tLYWP/vpWTxw//0/WpH34G96nQY8vuaJQUdH4KkOeXy4LBM+QCs8N5K6XMiDDP5G4VrrjbJZBrvXEBguywQ3sO98jw9WbyS2IVvHdxmSk3QsGIYxCo7/vc6SgsWL9uoPHEY2qNVJE/GoZgb6262ou2jAHUlhCAuXo7avH5c7LWg1OXClywKzwwOb0w2FjIaCFkNGUwhRSBCvUaGruQae1AI8WfQWjrzxZ0i2P47lSxfD4pTDRNTtkDaUCGrYsPULCxY/+CiS0iZh25YPEN9yEtkTEnAswAHPdCXyn/kECJXUbH5w02Q6hPKazRY8+eSTw4zP0Piq0uC5VYoNXND3VtKYvtYYzU5AHrQ2esrRjBDD5PJzlX/eXNGwaHNmA34+fTpWFiQjwOvF9oN1CLbTWJ4VA5cECFXRQJASsLsBp4c18lmhR7QrY8HbNUmQ/OCv2P2L5zDxxCu4q6AAzX1u0LAPSTgvwyA6QIzPqroQPutOJM1Pwcn9p0HVlGPhgknYUdKK5FVa/Paz40Ar8IP8p54KjQvxNrbWs5L1nw1uWaxQYMxrBWuW/yi1d9uANtmNkAXKry505Oa6pJZ5x89Wbnjx1IXcD/Iu4KEpqbj3oUmYFCDDvkMNuKg3YmFSGDzKHqjkYqRGBUEipmDod8DrpSCjPJgSLMHJn9+LO0VXkJK/DE1GGySiG78NATIpmtvbUSuLxeN3LQAaulB5vBj3xirQWm3DhNxwGCg7tm5rwpyFaX+KjUnYW1ZZxiaEfk2gFyQW8NjIqdZ/ikf5dQZNxJ7TbYdL4kBM+IRTD6iW3dnYWzer/ED5Kz//4Fze9rvP4eklqZicE4vv5MTC3WKHvqwDhk4G/STdSCrC9Gg1AlU0uvrFSGY6ka51wSSehube4QlHzioZB95tdGPO0kVAbAg+2b4X0ZZ6xM6chk/PNEM7ORGFb+0gzoP1m9P+7b+9CiekLsmYqMYxSsMfMvPWv4XoelzbYMqGRYB+hxWM2IoQTcjZTJsuH6HOtLKTZ361du+5u5F8Dg/mKjArchpS54ZCa5fA0mfD2SoDLFY3gtQSRAfJER2qhqnfRZI/IR6GE+xSl1qGg+dqEDwrF/MWpaG2vAYdVafw/dmxKClrh+aeMJyo60Dpe27Mz07fREmprtraGnbjjh+3J67f1cwAdqcNNqkJsWFxZxZ571hikvaqu5ieH763re6n76n1YqJE0mQSfC9xLu5amoDeeisaa41oae1HfYQNwUoaCRoV1HIR+mweONzu6+w5YseFq+S4UNuAc5IE/CBvAWC0YN9nhzBPaQGc4eiKtCB1eghWPv8pWer2BPVH/q6s6oTPzjE/bjcMupWe4fhhc9hgk1ghFYvNusgFz3dRyb+r76++v+Zc/TNn7K6Z664ex9SZwFyPFk/lTUeAhUFFeTvamxj0RrkhU1AIVkowNVzN+hsmh4vNQHZ7AKVUAkN3J45aNHjs4fuBmFDs/ehzRBsuI0M3CXuPtiLliUQcLq9H6+dAyoyp23LvWtTUY+sG5ddZtzVu+P0GlnsMSW9zw8r0gQ6iemM88W9E2Se+oY5VzjhtKt5waZ9l6aXAWmzrq8XqiQlYtTgVcZDiyhfd+KK6Dx67F20T7PDKKMQESiFxWhARpEKwQokPz7ugK3gAoTMnomTvaTSe2I/vpkai5bIVotkq9LidKHzlGDAFXQ/O/fd1HokLcs+Nd4D58fXHKD4aQrHLX/1eK8RKMcKi4s5P7korcNGeYBvVs+RCZfWzm4/Wz96cW49vT4pEqlqLh78zBV6zE5+fagVa7KhtkSE8dQYmentRfOgCpLMXI+2+hWg5pkfF7h14cLISUkUwLva3IHFBAp7+4DBQB6x5aPUjWbnzzfVtdRD5bbnbHqP+Ug1DXfP4+u39sNNWKAOVvXJX1DuLAye9Q0U75+2vOlS07fOOWYjtwN+MJ7AoYTLU4UHITgyF3aXEpGlzYOyVorGkBU+IGvDJb7fg05IK/DRVjsi4GFSUtSNiUTiKrzZhX1EHFizM+vXs1HkHTlYeh9fj16vjAbf0eSRCQHYnmccOqBgkRCWeusd5X1qdvXpxm7j5P44fNeuOt1cHIhYQTQe+ExWN2fpuJEUk4fsPREJ5pQfd587hvrhQxEfE4XxZJwyTJGCC3Fj9sxJIU6M+uT9zxX/axBZW0tK0//vD4wFj8k0u9qtKDAOrzQS7zIzAwOADWjr5gEvlFhnjupY2iasfaz/bt3yLvg2IasO3pp3AvdMXYWJmBBYlh6DzSi92NbQgMTcEWWlRmPqLLcBV2H7102efTJyegMamRhLG+Vefq3GDMf4QHAXKy8DpscMmNkMml3tjZXG7QnsidrWZOwPN6tYXah0t6945CNE7x45iWT4wPzoN2qQwrFxKEoDdyPrZO2g+AhTcVfA9iVLWdOnyRXi/PisPfowBvrKvDzKs1+uCx+6Bg3ZArPGa4sUpz4R2xz9vUxnXVONqwc5P3Jk7mTPS4BnAsZ4w/PFkN1AN5GTPee/5Z158t8vRDrvN4f823TjDP+yTlx4SdhH1QRoi6wsSxb+s7A57WRZAi4zerm+eb7j09B/13TMRBLHCTm9eNGnZD70qNxx9Tv+Hrv3ww49bBID/B4M27mV7WPY/AAAAAElFTkSuQmCC" alt="" />
                                <br>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>ID da fatura: {{$encomenda->id}}</h2>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <strong>Dados do cliente:</strong><br>
                                    {{$encomenda->cliente->user->name}}<br>
                                    E-mail: {{$encomenda->cliente->user->email}}<br>
                                    NIF: {{$encomenda->nif}}<br>
                                    <br>
                                </address>
                            </div>
                            <div class="col-xs-6">
                                <address>
                                    <strong>Enviado para:</strong><br>
                                    {{$encomenda->endereco}}<br>
                                    <br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <strong>Pagamento:</strong><br>
                                    Método:
                                    @if ($encomenda->tipo_pagamento == 'MC')
                                        MasterCard<br>
                                    @elseif($encomenda->tipo_pagamento == 'PAYPAL')
                                        PayPal<br>
                                    @else
                                        Visa<br>
                                    @endif
                                    Referência: {{$encomenda->ref_pagamento}}<br>
                                    <br>
                                </address>
                            </div>
                            <div class="col-xs-6">
                                <address>
                                    <strong>Data da encomenda:</strong><br>
                                    {{$encomenda->data}}<br>
                                    <br><br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Sumário</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="line">
                                            <td></td>
                                            <td><strong>NOME</strong></td>
                                            <td class="text-right"><strong>QUANTIDADE</strong></td>
                                            <td class="text-right"><strong>UNIDADE</strong></td>
                                            <td class="text-right"><strong>SUBTOTAL</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tshirts as $tshirt)
                                        <tr>
                                            <td></td>
                                            @if ($tshirt->estampa)
                                            <td><strong>Estampa: {{$tshirt->estampa->nome}}</strong><br>{{$tshirt->estampa->descricao}}</td>
                                            @else
                                            <td><strong>Estampa: Inacessivel</strong><br>No momento da faturação a estampa requerida não se encontrava disponivel</td>
                                            @endif
                                            <td class="text-right">{{$tshirt->quantidade}}</td>
                                            <td class="text-right">{{$tshirt->preco_un}} €</td>
                                            <td class="text-right">{{$tshirt->subtotal}} €</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right"><strong>Taxas</strong></td>
                                            <td class="text-right"><strong>N/A</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            </td><td class="text-right"><strong>Total</strong></td>
                                            <td class="text-right"><strong>{{$encomenda->preco_total}} €</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right identity">
                                <p>MagicShirts<br><strong>{{date('d-m-Y')}}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->
        </div>
    </div>
</body>
</html>
