set :application, "Presidium"
set :repository,  "git@bitbucket.org:spolster/presidium.git"

# turn off output colors on Windows
disable_log_formatters if (ENV['OS'] == 'Windows_NT')

# :deploy_to is defined in the environment files.

set :scm, :git

# set the system user for the remote servers.
set :user, "seb"

# Keep a git repo on the server.
set :deploy_via, :remote_cache

# Don't use sudo as it shouldn't be necessary
set :use_sudo, false

# Define servers to deploy to. These can be moved to environment files if different per env.
server 'talk.spol.co', :web

set :db_name, "presidium"
set :db_user, "presidium"
set :db_pass, "presidium"

# Define shared folders to be created by deploy:setup
set :shared_children, %w(images images/profile logs)

set :group_writable, false

# deployment process
after "deploy:setup", "mysql:init"

after "deploy:update_code", "deploy:create_symlinks"
after "deploy:update_code", "php:composer"
after "deploy:update_code", "apache:update_vhost"
after "deploy:update_code", "laravel:perms"
after "deploy:update_code", "laravel:migrate"


namespace :deploy do

	desc "Create symlinks to shared data folders - e.g. uploaded images"
	task :create_symlinks, :roles => :web do
		# link in the images directory...
		run "rm -r #{current_release}/public/images"
		run "ln -s #{deploy_to}/#{shared_dir}/images #{current_release}/public/images"
		run "mkdir -p #{current_release}/public/images/profile"

		# ...and the logs too.
		run "rm -r #{current_release}/app/storage/logs"
		run "ln -s #{deploy_to}/#{shared_dir}/logs #{current_release}/app/storage/logs"
	end
end

namespace :apache do

	desc "Update/Create Vhost file"
	task :update_vhost, :roles => :web do
		run "cp #{current_release}/config/apache/talk.spol.co.conf /etc/apache2/sites-available/talk.spol.co"
		run "sudo /usr/sbin/a2ensite talk.spol.co"
		run "sudo /usr/sbin/apachectl graceful"
	end

end

namespace :mysql do

	desc "Create application mysql user and db"
	task :init, :roles => :web do
		db_name = fetch(:db_name)
		db_user = fetch(:db_user)
		db_pass = fetch(:db_pass)
		root_pw = fetch(:mysql_root_pw)
		run "mysqladmin -uroot -p#{root_pw} create #{db_name}"
		run "mysql -uroot -p#{root_pw} -e \"GRANT ALL PRIVILEGES ON #{db_name}.* TO '#{db_user}'@'localhost' IDENTIFIED BY '#{db_pass}'\""

	end

end

namespace :php do

	desc "Install composer dependancies"
	task :composer, :roles => :web do
		run "cd #{current_release} && composer install --no-progress -o"
	end

end

namespace :laravel do

	desc "Run artisan migrations"
	task :migrate, :roles => :web do
		run "cd #{current_release} && php artisan migrate"
	end

	desc "Set appropriate file permissions"
	task :perms, :roles => :web do
		run "chmod -R a+w #{current_release}/app/storage/cache"
		run "chmod -R a+w #{current_release}/app/storage/meta"
		run "chmod -R a+w #{current_release}/app/storage/sessions"
		run "chmod -R a+w #{current_release}/app/storage/views"
	end

end