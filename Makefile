clean:
	docker system prune --force
ssh:
	docker run -it -v `pwd`:/app -w /app ginvoicing/php:latest /bin/bash
install:
	docker run -it -v `pwd`:/app -w /app ginvoicing/php:latest composer.phar install
update:
	docker run -it -v `pwd`:/app -w /app ginvoicing/php:latest composer.phar update
test:
	docker run -it -v `pwd`:/app -w /app ginvoicing/php:latest composer.phar run-script build
	docker run -it -v `pwd`:/app -w /app ginvoicing/php:latest composer.phar run-script test
