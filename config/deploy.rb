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

set :group_writable, false

# deployment process
after "deploy:update_code", "deploy:create_symlinks"
after "deploy:update_code", "php:composer"


namespace :deploy do

	desc "Create symlinks to shared data folders - e.g. uploaded images"
	task :create_symlinks, :roles => :web do
		# link in the uploads directory
		#run "rm -r #{current_release}/media"
		#run "ln -s #{deploy_to}/#{shared_dir}/media #{current_release}/media"
		#run "ln -s #{deploy_to}/#{shared_dir}/wkhtmltox #{current_release}/bin/wkhtmltox"
	end

end

namespace :php do
	desc "Install composer dependancies"
	task :composer, :roles => :web do
		run "cd #{current_release} && mkdir bin && wget -qO- http://getcomposer.org/installer | php -- --install-dir=bin"
		run "cd #{current_release} && php #{current_release}/bin/composer.phar install --no-progress -o"
	end
end