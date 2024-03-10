#!/bin/sh

# Source Antigen
source /home/www-data/.antigen/antigen.zsh

# Set up oh-my-zsh
antigen use oh-my-zsh

# Set up plugins
antigen bundle git

antigen bundle zsh-users/zsh-completions
antigen bundle zsh-users/zsh-autosuggestions
antigen bundle zsh-users/zsh-syntax-highlighting
antigen bundle zsh-users/zsh-history-substring-search

# Set up theme!
antigen theme spaceship-prompt/spaceship-prompt
source /home/www-data/.custom.zshrc

# Run all that config
antigen apply

# Zoxide

# Set up aliases
alias m="/app/bin/magento"
alias cl="clear"
alias x="exit"
