# CMO Technical Interview

## The Brief

Create a VAT calculator that shows a history of calculations requested that can be exported as a CSV file.

- For user provided monetary value V and VAT percentage rate R, calculate and display both sets of calculations:
  - Where V is treated as being ex VAT show the original value V, the value V with VAT added and the amount of VAT calculated at the rate R.
  - Where V is treated as being inc VAT show the original value V, the value V with VAT subtracted and the amount of VAT calculated at the rate R.
- The results from each requested set of calculations should be stored, and displayed on screen as a table of historical calculations.
- The history should be able to be cleared and exportable to a CSV file.
- Host your final code on a public git remote (github, bitbucket, etc) that we can access and ensure you have added a README file to document your specific files for us to review.

You are free to use your preferred stack, be it WAMP/MAMP or Docker with K8s etc. You must however ensure you use PHP7.4 - 8.2 and MariaDB.

### Bonus points

- Migrate or build your calculator on a Symfony project
- Prevent against XSS & SQL injection

## Prerequisites

- PHP8
- Composer
- Symfony CLI

## Getting started

1. Install dependencies `composer install`
2. Set up your .env file ensuring you have database credentials in there
3. Create the database `php bin/console doctrine:database:create`
4. Set up the database `php bin/console doctrine:migrations:migrate`
5. Start the dev server `symfony server:start` and navigate to [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

## Running tests

1. Create the database `php bin/console doctrine:database:create --env=test`
2. Set up the database `php bin/console doctrine:migrations:migrate --env=test`
3. Run the tests `php bin/phpunit`

## To Enhance

[ ] Style the front-end
[ ] Add more tests

## Comments

I've never used Symfony before.
This took about half a day.
Check out [https://github.com/joebailey26/cmo/commit/fabbcf4a5f7e6ac44b4c331b03a15755b0f17152](https://github.com/joebailey26/cmo/commit/fabbcf4a5f7e6ac44b4c331b03a15755b0f17152) for the files I actually changed.
You can see a demo here [https://cmo.joebailey.xyz](https://cmo.joebailey.xyz)
