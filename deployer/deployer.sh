DOCKER_COMPOSE_PATH=../docker-compose.yml

magic() {
    showWelcomeMessage
    buildDocker
    stopDocker
    startDocker
    prepareLaravel
}

showWelcomeMessage() {
    cat ./welcome_prompt.txt
}

buildDocker() {
    echo "Docker building..."
    docker-compose -f $DOCKER_COMPOSE_PATH build
}

startDocker() {
    echo "Docker starting..."
    docker-compose -f $DOCKER_COMPOSE_PATH up -d
}

stopDocker() {
    echo "Docker stopping..."
    docker-compose -f $DOCKER_COMPOSE_PATH kill
}

composerInstall() {
    echo "Composer installing..."
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend composer install
}

prepareLaravel() {
    echo "Preparing Laravel..."

    composerInstall
    npmInstall
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend chmod -R 777 ./storage
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend cp .env.example .env
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend php artisan migrate:fresh --seed
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend php artisan view:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend php artisan config:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend php artisan cache:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend php artisan route:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm backend php artisan storage:link
}

npmInstall() {
    echo "Npm installing..."
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm frontend npm install
}

help() {
    echo "Usage: ./deployer.sh [command]"
    echo "Commands:"
    echo "  magic: Build all app"
    echo "  up: Start all services"
    echo "  down: Stop all services"
    echo "  help: Show available commands"
}

if [ "$1" = "magic" ]; then
    magic
elif [ "$1" = "up" ]; then
    startDocker
elif [ "$1" = "down" ]; then
    stopDocker
elif [ "$1" = "help" ]; then
    help
else
    echo "Invalid command"
    help
fi