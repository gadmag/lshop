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
//set('writable_use_sudo', false);
//set('http_user', 'lotus44476');
//add('writable_dirs', ['bootstrap/cache', 'storage', 'vendor','node_modules']);


// Hosts

host('vh130.timeweb.ru')
    ->user('lotus44476')
    ->set('deploy_path', '~/lshop');

// Tasks


desc('Vendor');
task('deploy:vendor:lshop', function () {
    cd('{{release_path}}');
    run('/opt/php7.1/bin/php /usr/local/bin/composer install');
});
desc('Execute artisan migrate');
task('artisan:migrate', function () {
    run('/opt/php7.1/bin/php {{release_path}}/artisan migrate --force');
});

desc('Execute artisan db:seed');
task('artisan:db:seed', function () {
    $output = run('/opt/php7.1/bin/php {{release_path}}/artisan db:seed --force');
    writeln('<info>' . $output . '</info>');
});

task('deploy:chmod', function () {
    cd('{{release_path}}');
    run('mkdir node_modules vendor && chmod 777 -R node_modules vendor storage bootstrap && chmod 755 -R public resources routes app config');
});

task('deploy:compile-assets', function () {
    cd('{{release_path}}');
    run('gulp --production');
});

desc('Execute artisan config:cache');
task('artisan:config:cache', function () {
    run('/opt/php7.1/bin/php {{release_path}}/artisan config:cache');
});
desc('Execute artisan route:cache');
task('artisan:route:cache', function () {
    run('/opt/php7.1/bin/php {{release_path}}/artisan route:cache');
});
desc('Execute artisan view:clear');
task('artisan:view:clear', function () {
    run('/opt/php7.1/bin/php {{release_path}}/artisan view:clear');
});
desc('Execute artisan optimize');
task('artisan:optimize', function () {
    $deprecatedVersion = 5.5;
    $currentVersion = get('laravel_version');
    if (version_compare($currentVersion, $deprecatedVersion, '<')) {
        run('/opt/php7.1/bin/php {{release_path}}/artisan optimize');
    }
});

desc('Execute artisan storage:link');
task('artisan:storage:link', function () {
        run('/opt/php7.1/bin/php {{release_path}}/artisan storage:link');
});

/**
 * Main task
 */
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:chmod',
//    'deploy:vendors',
//    'deploy:writable',
    'deploy:vendor:lshop',
    'artisan:migrate',
//    'artisan:db:seed',
    //'deploy:compile-assets',
    'artisan:storage:link',
    'artisan:view:clear',
//    'artisan:cache:clear',
    'artisan:config:cache',
//    'artisan:optimize',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
after('deploy', 'success');

