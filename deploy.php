<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'lotos');

// Project repository
set('repository', 'https://github.com/gadmag/lshop.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);

// Writable dirs by web server 
add('writable_dirs', ['bootstrap/cache', 'storage', 'vendor','node_modules']);


// Hosts

host('vh130.timeweb.ru')
    ->user('lotus44476')
    ->set('deploy_path', '~/public_html');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// Задача для деплоя. Установить NPM компоненты
task('deploy:install-npm', function() {
    run('cd {{release_path}} && npm install');
});

// Ещё одна задача: скомпилировать все фронтенд файлы, в моём случае
// это делается через Grunt.js
task('deploy:compile-assets', function() {
    run('cd {{release_path}} && gulp --production');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
after('artisan:config:cache', 'deploy:install-npm');
after('deploy:install-npm', 'deploy:compile-assets');
// Migrate database before symlink new release.

after('deploy:symlink', 'artisan:migrate');

