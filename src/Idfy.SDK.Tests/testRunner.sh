#!/bin/bash

# Config variables. Set up these to match your project
UNIT_DIR="./tests/"
INTEGRATION_DIR="./integration/"
SOURCE_DIR="../Idfy.SDK/"
PHPUNIT="./vendor/bin/phpunit --colors=always --bootstrap vendor/autoload.php "

# Script state variables. Don't touch these.
AUTO=false
UNITS=true
INTEGRATION=false

C0="\033[0m"
C4="\033[0;34m"
C5="\033[0;35m"
C6="\033[0;36m"

run_specific_test(){
	./vendor
}

run_all_tests(){
	if [ $UNITS = true ] ; then
		echo -e "${C5}Running all unit tests...${C0}"
		$PHPUNIT "$UNIT_DIR"
	fi
	if [ $INTEGRATION = true ] ; then
		echo -e "${C5}Running all integration tests...${C0}"
		$PHPUNIT "$INTEGRATION_DIR"
	fi
}

run_specific_test(){
	$PHPUNIT $SPECIFIC
}

usage(){
	printf "PHPUnit Testrunner Wrapper (C) 2018 Kare Andersen / SIFR AS\n"
	printf "Usage: testRunner.sh [option] [test file]\n"
	printf "  -h --help          This text\n"
	printf "  -a --auto          Run tests automaticaly when source files or tests change\n\n"
	printf "  -i --integration   Run tests from the integration/ folder\n\n"
	printf "  -u --no-units      Don't run unit tests (implies -i)\n\n"
}

runloop(){
	TEST_DIRS=""
	if [ "$UNITS" = true ] ; then
		TEST_DIRS="$UNIT_DIR"
	fi
	if [ "$INTEGRATION" = true ] ; then
		TEST_DIRS="$TEST_DIRS $INTEGRATION_DIR"
	fi

	inotifywait -mq -r -e create,modify,move,close_write $TEST_DIRS $SOURCE_DIR --format "%f" \
		| while read f ; do
			if [[ "$f" =~ .*php$ ]]; then
				printf "\n${C6}$f${C5} just changed${C0}. "
				break
			fi
		done
	run_all_tests
	runloop
}

for args in "$@"; do
	case $args in
		-a | --auto)
			AUTO=true
			;;
		-i | --integration)
			INTEGRATION=true
			;;
		-u | --no-units)
			UNITS=false
			INTEGRATION=true
			;;
		-h | --help)
			usage
			exit
			;;
	esac
done	

if [ ! -x "$PHPUNIT" ] ; then
	composer -q install
fi

if [ "$UNITS" = false ] ; then
	echo -e "\n${C4}Disabled unit testing. Only integration tests will run.${C0}"
elif [ "$INTEGRATION" = true ] ; then
	echo -e "\n${C4}Integration tests will also be run.${C0}"
fi


if [ "$AUTO" = true ] ; then 
	echo -e "${C4}Automatic test mode enabled. Waiting for changed files...${C0}"
	runloop 
else
	run_all_tests
fi
