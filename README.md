<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

Teste Ihold


- Clonar repositório
  >git clone https://github.com/tiagopimentta/teste_ihold


- Entrar no repositório clonado
  >cd teste_ihold


- Subir os serviços com docker
  >make up

- Copia o arquivo .env.example para o .env
  >make env

- Copia o arquivo .env.example para o .env
  >make composer
 
- Gera o secret jwt
  >make jwt

- Install migration and seeders
  >make db

- Executar os testes
  >make test

- Para documentação (swagger), execute o comando a baixo para gerar um token válido. 
  >make token

- Swagger API
  >http://localhost:8001/api/documentation
