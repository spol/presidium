set :deploy_to, "/var/www/talk.spol.co"

set :environment, "Production"

after "deploy", "deploy:cleanup"