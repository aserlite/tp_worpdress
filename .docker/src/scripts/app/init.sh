#!/bin/zsh
echo "Installing composer packages..."

source ~/.zshrc

BASEDIR=$PWD
COMPOSER_VENDOR_PATH="vendor/"
WP_INCLUDE_PATH="wp-includes/"
WP_PLUGIN_PATH="plugins/"
WP_THEMOSIS_PATH="cms/"
WP_BEDROCK_PATH="wp/"
IFS=$'\n'
cd "$BASEDIR"

for FILE in $(find . -type f -name "composer.json" 2>/dev/null); do
	if [[
	  $FILE == *"$COMPOSER_VENDOR_PATH"*
	  || $FILE == *"$WP_PLUGIN_PATH"*
	  || $FILE == *"$WP_INCLUDE_PATH"*
	  || $FILE == *"$WP_THEMOSIS_PATH"*
	  || $FILE == *"$WP_BEDROCK_PATH"*
  ]]; then
		continue
	fi
	DIR=$(dirname "$FILE")
	DIR=${DIR:1}
	echo "Installing composer packages in '$BASEDIR$DIR'..."
	composer install
done

echo "Installing node modules..."
cd $BASEDIR
BASEDIR=$PWD
NODE_MODULES_PATH="node_modules/"
IFS=$'\n'
cd "$BASEDIR"

npm install --global yarn

for FILE in $(find . -type f -name "package.json" 2>/dev/null); do
  if [[
    $FILE == *"$NODE_MODULES_PATH"*
    || $FILE == *"$COMPOSER_VENDOR_PATH"*
    || $FILE == *"$WP_PLUGIN_PATH"*
    || $FILE == *"$WP_INCLUDE_PATH"*
    || $FILE == *"$WP_THEMOSIS_PATH"*
    || $FILE == *"$WP_BEDROCK_PATH"*
  ]]; then
    continue
  fi
	DIR=$(dirname "$FILE")
	DIR=${DIR:1}
	echo "Installing node modules in '$BASEDIR$DIR'..."
	cd "$BASEDIR$DIR"
	yarn
done

cd $BASEDIR

if test -f "artisan"; then
    php artisan key:generate
fi
