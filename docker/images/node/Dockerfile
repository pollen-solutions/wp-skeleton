FROM node:17

# Arguments defined in docker-compose.yml
ARG USER_UID
ARG USER_NAME

## Create system user to run Node and Npm
RUN useradd ${USER_NAME} --uid ${USER_UID} -m || useradd ${USER_NAME} -m

# Set working directory
WORKDIR /usr/src/app