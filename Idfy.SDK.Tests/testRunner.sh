#!/bin/bash

if [ ! -x ./vendor/bin/phpunit ]; then
	composer install
fi

for testCase in ./*.php; do
	./vendor/bin/phpunit --bootstrap vendor/autoload.php $testCase
done

