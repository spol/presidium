load 'deploy' if respond_to?(:namespace) # cap2 differentiator

require 'rubygems'
require 'railsless-deploy'
require 'capistrano/ext/multistage'

set :stages, %w(prd)
set :default_stage, "prd"

load 'config/deploy'