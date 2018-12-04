#!/bin/bash

PHPUNIT="./vendor/bin/phpunit --colors=always "
AUTO=false
TEST_DIR="./"
SOURCE_DIR="../Idfy.SDK/"

run_specific_test(){
	./vendor
}

run_all_tests(){
	$PHPUNIT --bootstrap vendor/autoload.php ./tests
}

run_specific_test(){
	$PHPUNIT --bootstrap vendor/autoload.php $SPECIFIC
}

usage(){
	printf "PHPUnit Testrunner Wrapper (C) 2018 Kare Andersen / SIFR AS\n"
	printf "Usage: testRunner.sh [option] [test file]\n"
	printf "  -h\t --help \t This text\n"
	printf "  -a\t --auto \t Run tests automaticaly when source files or tests change\n\n"
}

for args in "$@"; do
	case $args in
		-a | --auto)
			AUTO=true
			;;
		-h | --help)
			usage
			exit
			;;
	esac
done	

if [ ! -x $PHPUNIT ]; then
	composer install
fi

run_all_tests

if [ $AUTO = true ] ; then
	inotifywait -m -r -e create -e create,modify,move,close_write $TEST_DIR $SOURCE_DIR --format "%f" | while read f

	do
		if [[ "$f" =~ .*php$ ]]; then
			printf "$f changed! running tests \n"
			run_all_tests
		fi
	done
fi

