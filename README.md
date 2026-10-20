# SGMO-Industrial 🏭
> **Sistema de Gestão de Manutenção Operacional e Industrial**

O SGMO-Industrial é uma aplicação web desenvolvida para otimizar o fluxo de trabalho de equipas de manutenção em ambientes industriais. O sistema permite o acompanhamento do ciclo de vida dos equipamentos, gestão de ordens de trabalho (manutenção preventiva e corretiva) e controlo de componentes, focando na redução do tempo de inatividade (*downtime*) e no aumento da produtividade operacional.

---

## 🛠️ Tech Stack & Arquitetura

O projeto está a ser construído seguindo as boas práticas do ecossistema **Laravel**, priorizando uma arquitetura limpa, escalável e de elevada manutenibilidade.

* **Backend Framework:** PHP 8.x + Laravel 11/13
* **Arquitetura de Dados:** MySQL / PostgreSQL (Eloquent ORM, Migrations, Seeders)
* **Reatividade & UI:** Laravel Livewire + Blade Templates
* **Estilização:** Tailwind CSS
* **Autenticação & Autorização:** Laravel Fortify / Breeze (Controlo de Acessos baseado em Funções - RBAC)
* **Qualidade de Código:** Laravel Pint (Conformidade com os padrões PSR-12)

---

## 🚀 Funcionalidades Principais

- [x] **Estrutura Organizacional:** Mapeamento de secções e áreas industriais.
- [x] **Gestão de Ativos (Máquinas):** Cadastro e monitorização do estado operacional dos equipamentos (marca, modelo, número de série, estado).
- [x] **Inventário de Componentes:** Mapeamento de peças e componentes associados a cada máquina (`belongsTo` / `hasMany`).
- [ ] **Ordens de Trabalho (Work Orders):** Emissão, atribuição de técnicos, priorização e registo de horas de paragem (*downtime*).
- [ ] **Painel de Controlo (Dashboard):** Indicadores operacionais em tempo real construídos com componentes reativos em Livewire.

---

## 💻 Como Executar o Projeto Localmente

### Pré-requisitos
* PHP 8.2 ou superior
* Composer
* Node.js & NPM
* Base de dados MySQL / PostgreSQL

### Passo a Passo

1. **Clonar o repositório:**
   ```bash
   git clone [https://github.com/o-teu-utilizador/sgmo-industrial_V2.git](https://github.com/o-teu-utilizador/sgmo-industrial_V2.git)
   cd sgmo-industrial
