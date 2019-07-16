PEO - Personal Expenses Organizer
=================================

Side project to learn [Laravel](https://laravel.com), [VueJs](https://vuejs.org) and [Bootstrap 4](https://getbootstrap.com).

The project consists of:
* An API to handle requests to retrieve and store information on the database on a per user basis.
* A responsive web frontend developed in Vue.js to consume the API.

The main goal is to allow a user to log operations into a banking/credit card account:
* Cash withdraw/debits
* Incomes
* Transfers
* Credit card payments

This will allow the user to know in the present time how much money he realy has.


Technicals
----------

The backend will be supportted by MySQL as the DBMS and Laravel for running API.
We'll be using [Laravel Passport](https://laravel.com/docs/5.8/passport) (it's an official package made from the Laravel team) to handle API Authentication and Authorization as painless as possible.

For development purposes we'll use Laravel Homestead as our virtual environment as It offers almost everything we need out of the box.


### Getting up and running

First clone this repo to your computer.

Then, just follow the Homestead installation instructions [here](https://laravel.com/docs/5.8/homestead). When configuring the `folders` option on `Homestead.yaml` use the corret path to the folder where you cloned this repo.

__TIP:__ If using Vagrant with Hyper-V provider, you might want to take a look at [this](https://docs.microsoft.com/en-us/virtualization/community/team-blog/2017/20170706-vagrant-and-hyper-v-tips-and-tricks) and to share the the network adapter your computer uses to access the internet with the hyper-v switch you'll use.

After a successful `vagrant up` command, ssh into your homestead instance with the command `vagrant ssh`. Go to the /var/www/mah folder. You should see all the project's files.

