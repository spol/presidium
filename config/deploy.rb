set :application, "Beefeater Postcards"
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

set :group_writable, false

# deployment process
after "deploy:setup", "mysql:init"

after "deploy:update_code", "deploy:create_symlinks"
after "deploy:update_code", "php:composer"
after "deploy:update_code", "apache:update_vhost"
after "deploy:update_code", "laravel:migrate"


namespace :deploy do

	desc "Create symlinks to shared data folders - e.g. uploaded images"
	task :create_symlinks, :roles => :web do
		# link in the uploads directory
		#run "rm -r #{current_release}/media"
		#run "ln -s #{deploy_to}/#{shared_dir}/media #{current_release}/media"
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
		run "mysql -uroot -p#{root_pw} -e \"GRANT ALL PRIVILEGES ON #{db_name}.* TO '#{db_user}'@'localhost' IDENTIFIED BY '#{db_pass}'\""

	end

end

namespace :php do

	desc "Install composer dependancies"
	task :composer, :roles => :web do
#		run "cd #{current_release} && mkdir bin && wget -qO- http://getcomposer.org/installer | php -- --install-dir=bin"
		run "cd #{current_release} && composer install --no-progress -o"
	end

end

namespace :laravel do

	desc "Run artisan migrations"
	task :migrate, :roles => :web do
		run "cd #{current_release} && php artisan migrate"
	end

end