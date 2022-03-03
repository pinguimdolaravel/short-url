# API TDD

## Sobre

Projeto para fins educacionais e de aprendizado. Desenvolvido em formato Live no canal 🐧 **Pinguim do Laravel**.

📺 Acompanhe: [\#16 - Laravel | TDD](https://www.youtube.com/watch?v=-WUq9QilQVU)

## TO DO

### Desafio

- [ ] Garantir que o código da url curta não se repita

----

- [X] Salvar um endpoint
    - [X] Precisar enviar o endpoint que queremos encurtar
    - [X] Endpoint tem que ser válido
    - [X] não pode se repetir
    - [X] Esperamos receber uma url encurtada pdl.test/YH21
    - [X] Esperamos receber um status code 201
- [X] Deletar a url curta baseado na url gerada
    - [X] url precisa existir
    - [X] receber um 204[no content] caso deletado com sucesso
- [X] Pegar estatistica de uso da url /stats/YH21
    - [X] ultima vez que foi utilizada

```json
{
    "last_visit": "2022-02-17T13:45:00"
}
```

    - [X] Receber quantas vezes a url foi usada

```json
{
    "visits": [
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