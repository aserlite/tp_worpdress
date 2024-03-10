SPACESHIP_ADX_COLOR="${SPACESHIP_ADX_COLOR="magenta"}"
SPACESHIP_ADX_CONTENT="${SPACESHIP_ADX_CONTENT="[ADX ~ Docker] × "}"
SPACESHIP_TIME_SHOW=true

spaceship_adx() {
    spaceship::section \
        "$SPACESHIP_ADX_COLOR" \
        "$SPACESHIP_ADX_CONTENT"
}

SPACESHIP_PROMPT_ORDER=(
    amp       # AmphiBee
    user      # Username section
    dir       # Current directory section
    host      # Hostname section
    git       # Git section (git_branch + git_status)
    exec_time # Execution time
    line_sep  # Line break
    jobs      # Background jobs indicator
    exit_code # Exit code section
    char      # Prompt character
)

SPACESHIP_RPROMPT_ORDER=(
    time
)
