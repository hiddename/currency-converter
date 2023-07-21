FROM postgres:15.3-alpine3.18

RUN apk update && apk --no-cache add sudo bash zsh vim nano git curl

RUN sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
