FROM nginx:1.20.2-alpine

RUN apk update && apk --no-cache add sudo bash zsh vim nano git curl

RUN sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
