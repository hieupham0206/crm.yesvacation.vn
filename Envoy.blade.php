@servers(['web' => 'root@10.101.118.149'])

@setup
    $repository = 'git@gitlab.cloudteam.vn:username/project.git';
    $releases_dir = '/var/www/html/mylifehrm/';
@endsetup

@story('deploy')
    clone_repository
    run_composer
    laravel
@endstory

@task('clone_repository')
    @if (is_dir($releases_dir . '/app'))
        echo 'Pulling repository...'

        cd {{ $releases_dir }}
        git pull origin master
    @else
        echo 'Cloning repository...'

        git clone $repository
    @endif
@endtask

@task('run_composer')
    echo "Starting composer install..."

    cd {{ $releases_dir }}
    composer install --prefer-dist --no-scripts --no-plugins -q -o
@endtask

@task('laravel')
    echo "Starting laravel initialize..."

    cd {{ $releases_dir }}
    cp env/.env.test .env

    php artisan key:generate

    php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan clear-compiled
    composer dump-autoload --classmap-authoritative

    php artisan migrate:fresh && php artisan db:seed
@endtask

@finished
    @slack('https://hooks.slack.com/services/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', '#')
@endfinished
