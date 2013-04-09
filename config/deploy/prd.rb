set :deploy_to, "/var/www/talk.spol.co"

set :environment, "Production"

set :mysql_root_pw, "QuJH92G842viu4V"

after "deploy", "deploy:cleanup"