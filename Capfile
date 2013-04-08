load 'deploy' if respond_to?(:namespace) # cap2 differentiator

require 'rubygems'
require 'railsless-deploy'
require 'capistrano/ext/multistage'

set :stages, %w(stg prd)
set :default_stage, "stg"

load 'config/deploy'