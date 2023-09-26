
![Logo](https://i.ibb.co/D5HDbMM/Logo-3-100.jpg)
# RAKOLI WEB APP

Rakoli is a web and mobile software solution for financial service agents that enables agents to manage their business financial operations, exchange account floats and earn additional revenue by performing tasks for other businesses (providers) and referring other agents to use the platform.

Rakoli has a special provider account enables businesses to take advantage of the large network of agents using Rakoli to perform various tasks such data research and verification at a cost-efficient price. Additionally, the provider account gives access to advertising services for businesses to agents and sell the business services through agents in Rakoli for maximizing sales outreach and facilitating business growth.

## Features

- Business Registration - Agent and Provider
- Multiple Branch Management
- Multiple Till Management
- Transaction Management
- Shift Management
- Loan Management
- Short Management
- Float Exchange
- Value-added Services Management
- Financial Reporting
- Subscription Management
- Referrals Management
## Installation

Please check the official laravel installation guide for server requirements before you start. [Laravel Documentation](https://laravel.com/docs/10.x/installation)


Clone the repository

    git clone git@github.com:emabusi2/rakoliwebapp.git

Switch to the repo folder

    cd rakoliwebapp

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations and seed the database (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
## Authors

- [Felix Mihayo](https://www.github.com/famsh5233)
- [Erick Mabusi](https://www.github.com/emabusi2)
## License

The Rakoli Web app is proprietary software owned by [Rakoli Systems (Tanzania)](https://rakoli.com)
