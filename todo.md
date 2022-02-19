# API TDD

- [X] Salvar um endpoint
    - [X] Precisar enviar o endpoint que queremos encurtar
    - [X] Endpoint tem que ser válido
    - [ ] não pode se repetir
    - [X] Esperamos receber uma url encurtada pdl.test/YH21
    - [X] Esperamos receber um status code 201
- [ ] Deletar a url curta baseado na url gerada
    - [ ] url precisa existir
    - [ ] receber um 204[no content] caso deletado com sucesso
- [ ] Pegar estatistica de uso da url /stats/YH21
    - [ ] ultima vez que foi utilizada

```json
{
    "last_access": "2022-02-17T13:45:00"
}
```

    - [ ] Receber quantas vezes a url foi usada

```json
{
    "daily_stat": [
        {
            "day": "2022-02-16",
            "qty": 20
        },
        {
            "day": "2022-02-17",
            "qty": 20
        }
    ],
    "total": 40
}
```

    



