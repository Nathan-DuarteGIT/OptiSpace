# Optispace

## Descrição
O Optispace é uma plataforma web que simplifica a gestão de recursos partilhados em organizações, oferecendo reservas automáticas de salas e equipamentos, otimização em tempo real e regras inteligentes para evitar conflitos e maximizar a eficiência.

## Funcionalidades
- **Reserva com Otimização de Espaço**: Sugere salas adequadas com base no número de participantes, equipamentos necessários e integração com calendários.
- **Gestão de Inventário de Equipamentos**: Permite consultar e reservar equipamentos com rastreio via código PIN.
- **Regras Inteligentes**: Liberta automaticamente reservas não confirmadas após 15 minutos, evitando "reservas fantasma".

## Tecnologias Utilizadas
- **Front-End**: HTML5, Tailwind CSS, JavaScript
- **Back-End**: PHP
- **Base de Dados**: MySQL (gerido via phpMyAdmin)

## Autores
- Nathan Duarte
- Andréa Rego

## Objetivo
Desenvolvido como projeto académico para a disciplina *Projeto de Tecnologias e Programação de Sistemas de Informação*. O Optispace visa demonstrar a aplicação de tecnologias web para resolver problemas reais de gestão de recursos, promovendo colaboração e produtividade em contextos empresariais.

## Como Executar
1. Clone o repositório: `git clone <URL-do-repositório>`
2. Configure um servidor local com PHP e MySQL (ex.: XAMPP).
3. Importe a base de dados via phpMyAdmin (ficheiro SQL disponível em `/database`).
4. Copie os ficheiros para o diretório do servidor (ex.: `htdocs`).
5. Instale as dependencias de node.js: npm install
6. Crie o ficheiro de output.css através do comando: npm run watch
7. Aceda à aplicação através de `http://localhost/optispace`.

## Licença
Este projeto é exclusivamente para fins académicos e não possui licença de distribuição comercial.