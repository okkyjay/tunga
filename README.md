# Tunga Interview Challenge

### Challenge

Write	a	process	that	imports	the	contents	of	a	JSON-file	cleanly	and	consistently	to	a	database.Preferably	this	is	done	as	a	background	job	in	Laravel.	Docker	use is encouraged(but	not	required)

When	analyzing	your	solution,	our	focus	is	mainly	on	its	structure.	We	prefer	to	see	a	solid,	
clean	and	maintainable	solution	that	is	not	100%	functional	or	finished,	rather	than	a	
complete	solution that	is	sloppy	or	hard	to	understand. We	are	particularly	interested	in	the	
thought	process	behind	your	approach.

### Requirements:
 - [Primary]	Write	a	process	such	that	it	may	be	terminated	(by	anything,	including	a	
   SIGTERM,	power	failure, what	have	you)	at	any	time,	after	which	it	may	resume	in	a	
   robust,	reliable	manner.	The	process	must	continue	exactly	where	it	left	off,	without	
   writing	duplicate entries
 - Design	your	solution	'for	the	future',	that	is:	taking	into	account	a	hypothetical	
   customer	who typically	changes and	extends their	requirements time	after	time.
 - The	data	model	must	be	sensible,	but	is	not	a	focus	of	the	test. Code	for	Eloquentmodels	or	any	other	access	structure	itself	is	not	crucial
 - Only	process	records	for	which	the	subject's	age	is	between	18	and	65	(or	is	
   unknown).

### How to run 
- At the root level of the project files, run `composer install` to install the project dependencies
- At the root level of the project files, run `cp .env.example .env` to create env file
- At the root level of the project files, run `php artisan key:generate` to generate application key
- At the root level of the project files, run `php artisan migrate` to migrate the database tables
- At the root level of the project files, run `php artisan serve` to serve the project
- At the root level of the project files, run `php artisan queue:work` 
- Application will run on http://localhost:8080 
